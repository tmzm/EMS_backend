<?php

namespace App\Http\Helpers;

use App\Enums\ReturnMessages;
use App\Http\Controllers\NotificationController;
use App\Models\Activity;
use App\Models\Category;
use App\Models\CategoryProduct;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

trait CreateUpdateHelper
{
    public function update_order_status($order,$request) : void
    {
        $order->update([
            'status' => $request['status'],
            'payment_status' => $request['payment_status']
        ]);

        $user = User::find($order->user_id);

        if($user->device_key !== null)
            self::send_order_notification_to_user($request,$user);
    }

    public function increase_every_product_by_quantity($order): void
    {
        $orderItems = $order->order_items;
        foreach ($orderItems as $item){
            $p = Product::find($item->product->id);
            if($p->is_quantity){
                $p->quantity += $item->quantity;
                $p->save();
            }
        }
    }

    public function create_user($data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'device_key' => $data['device_key'] ?? null,
            'image' => $data['image'] ?? null,
            'trademark_name' => $data['role'] == 'trademark_owner' ? $data['trademark_name'] : null
        ]);
    }

    public function create_product($request): void
    {
        $data = $request->validated();

        $image = self::save_image_to_public_directory($request);

        // Clean the name and create slug
        $slug = Str::slug($data['name']);
        // Check if slug already exists
        $count = Product::where('slug', $slug)->count();
        // If slug already exists, append a number to make it unique
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        $product = Product::create([
            'name' => $data['name'],
            'slug' => $slug,
            'user_id' => $request->user()->id,
            'description' => $data['description'],
            'price' => $data['price'],
            'image' => $image,
        ]);

        $categories = is_array($data['categories']) ? $data['categories'] : json_decode($data['categories']);

        foreach($categories as $category_id){
            CategoryProduct::create([
                'category_id' => $category_id,
                'product_id' => $product->id
            ]);
        }

        self::ok($product);
    }

    public function update_product($request,$product_id): void
    {
        $product = Product::find($product_id);

        if(!$product)
            self::notFound();

        $data = $request->validated();

        if(isset($data['image']) || $data['image'])
            $data['image'] = self::save_image_to_public_directory($request);

        if(isset($data['categories'])){
            foreach($product->category_products as $category){
                $isExists = 0;

                foreach($data['categories'] as $c){

                    if($c == $category->id){
                        $isExists++;
                    }

                }

                if($isExists == 0){
                    $category->delete();
                }
            }

            foreach($data['categories'] as $category){
                $isExists = 0;

                foreach($product->category_products as $c){
                    if($c->id == $category){
                        $isExists++;
                    }
                }

                if($isExists == 0){
                    CategoryProduct::create([
                        'product_id'=>$product->id,
                        'category_id'=>$category
                    ]);
                }
            }
        }

        $data = Arr::except($data, ['categories']);

        $product->update($data);

        self::ok($product);
    }

    /**
     * @throws GuzzleException
     */
    public function delete_product($product_id): void
    {
        $product = Product::find($product_id);

        if($product) {
            self::delete_image(public_path($product->image));

            $product->delete();

            self::ok();
        }

        self::notFound();
    }

    public function create_favorite($user_id,$product_id): void
    {
        if(Favorite::where('user_id',$user_id)?->firstWhere('product_id',$product_id))
            self::unHandledError('favorite already exists');

        if(!Product::find($product_id)) self::unHandledError('no such product');

        $favorite = Favorite::create([
            'product_id' => $product_id,
            'user_id' => $user_id
        ]);

        $favorite ? self::ok($favorite) : self::unHandledError("Couldn't create this favorite");
    }

    public function delete_user_favorite($favorite_id,$user_id): void
    {
        $favorite = Favorite::find($favorite_id)?->firstWhere('user_id',$user_id);

        if($favorite) {
            $favorite->delete();
            self::ok();
        }

        self::notFound();
    }

    public function create_category($request)
    {
        $validator = validator($request->all(),[
            'name' => 'required|unique:categories,name'
        ]);

        $data = $validator->validated();

        $category = Category::create($data);

        Activity::create([
            'user_id' => $request->user()->id,
            'description' => 'Create category ' . $category->name
        ]);

        self::ok($category);
    }

    public function edit_category($request,$category_id)
    {
        $category = Category::find($category_id);

        if($category){
            $category->update([
                "name" => $request['name']
            ]);

            self::ok($category);
        }

        self::notFound();
    }

    public function destroy_category($category_id)
    {
        $category = Category::find($category_id);

        if($category){
            $category->delete();

            self::ok();
        }

        self::notFound();
    }

}

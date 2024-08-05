<?php

namespace App\Http\Helpers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

trait TableGetterHelper
{
    public function filter_products($filters): void
    {
        $products = Product::filter($filters)->latest()->get();

        self::ok($products);
    }

    public function get_product_by_id($product_id): void
    {
        $product = Product::find($product_id);

        $product ? self::ok($product) : self::notFound();
    }

    public function get_all_favorites_by_user($request): void
    {
        $favorites = Favorite::latest()->where('user_id',$request->user()->id)->get();

        self::ok($favorites);
    }

    public function get_user_favorite_by_id($favorite_id,$user_id): void
    {
        $favorite = Favorite::find($favorite_id)?->firstWhere('user_id',$user_id);

        $favorite ? self::ok($favorite) : self::notFound();
    }

    public function get_all_categories(): void
    {
        self::ok(Category::latest()->get());
    }

    public function get_category($category_id)
    {
        $category = Category::find($category_id);

        if($category){
            self::ok($category);
        }else{
            self::notFound();
        }
    }
}

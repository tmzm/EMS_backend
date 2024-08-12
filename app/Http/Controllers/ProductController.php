<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Product;
use App\Models\Rate;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     *
     */
    public function index(Request $request)
    {
        self::filter_products(request(['search', 'categories','sort', 'take', 'skip','price']), $request->user()->id);
    }

    public function get_product_rate($product_id)
    {
        $rates = Rate::where('product_id',$product_id)->get();

        $sum = 0;

        foreach ($rates as $rate){
            $sum += $rate->number;
        }

        self::ok($sum / count($rates));
    }

    public function index_top_sellers()
    {
        self::ok(Product::withCount('order_items')->orderByDesc('order_items_count')->take(10)->get());
    }

    public function get_price($product_id)
    {
        $product = Product::where('id',$product_id)->select('price','is_offer','offer')->first();

        if($product->is_offer){
            $price = $product->price - $product->price * ($product->offer / 100);
        }else{
            $price = $product->price;
        }

        self::ok($price);
    }

    public function get_image($product_id)
    {
        self::ok(Product::where('id',$product_id)->select('image')->first()->image);
    }

    public function get_total_count()
    {
        self::ok(self::total_count(request(['search', 'categories','price']))->count());
    }


    /**
     * @param ProductCreateRequest $request
     */
    public function create(ProductCreateRequest $request)
    {
        self::create_product($request);
    }


    /**
     * @param $slug
     */
    public function show($slug)
    {
        $product = Product::where('slug',$slug)->first();
        $product ? self::ok($product) : self::notFound();
    }

    public function show_by_id($product_id)
    {
        $product = Product::find($product_id);
        $product ? self::ok($product) : self::notFound();
    }

    /**
     * @param ProductEditRequest $request
     * @param $product_id
     */
    public function edit(ProductEditRequest $request, $product_id)
    {
        self::update_product($request, $product_id);
    }


    /**
     * @param $product_id
     * @throws GuzzleException
     */
    public function destroy($product_id)
    {
        self::delete_product($product_id);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static byOwnerAndProductId($product_id, $id)
 * @method static filter($filters)
 */
class Product extends Model
{
    use HasFactory;

    protected $with = ['category_products'];

    protected $guarded = [];

    /**
     * Filter the products by passed filters
     *
     * @param $query
     * @param array $filters
     *
     * @return void
     */
    public function scopeFilter($query, array $filters): void
    {

        if($filters['search'] ?? false){

            $query->where(
                fn($query)=>
                $query
                    ->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
            );

        }

        if($filters['categories'] ?? false){

            $query->whereHas('category_products', fn ($query)

            => $query->whereIn('category_id', $filters['categories']));

        }

        if($filters['take'] ?? false){

            $query->take($filters['take']);

        }

        if($filters['skip'] ?? false){

            $query->skip($filters['skip']);

        }

        if($filters['price'] ?? false){

            $query->whereBetween('price',$filters['price']);

        }

        if($filters['sort'] ?? false){

            if($filters['sort'] == 'a-z'){

                $query->orderBy('name', 'asc');

            }

            if($filters['sort'] == 'prices-low-first'){

                $query->orderBy('price', 'asc');

            }

            if($filters['sort'] == 'prices-high-first'){

                $query->orderBy('price', 'desc');

            }

            if($filters['sort'] == 'oldest'){

                $query->oldest();

            }

        }else{

            $query->latest();

        }

    }

    /**
     * @return HasMany
     */
    public function category_products(): HasMany
    {
        return $this->hasMany(CategoryProduct::class);
    }

}

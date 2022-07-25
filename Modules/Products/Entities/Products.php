<?php

namespace Modules\Products\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Units\Entities\Units;
use Modules\Category\Entities\Category;
use Modules\Purchases\Entities\PurchasedProducts;

class Products extends Model
{
    use HasFactory;

    protected $fillable = ['name','sku','pricing_unit','price','category','alert_quantity','description','image','margin'
    ];
    protected $table='products';
    protected static function newFactory()
    {
        return \Modules\Products\Database\factories\ProductsFactory::new();
    }

    public function CategoryRel()
    {
        return $this->belongsTo(Category::class, 'category');
    }
    public function UnitRel()
    {
        return $this->belongsTo(Units::class, 'pricing_unit');
    }

    public function ProductsStock()
    {
        return $this->hasMany(PurchasedProducts::class, 'product_id','id');
    }

}

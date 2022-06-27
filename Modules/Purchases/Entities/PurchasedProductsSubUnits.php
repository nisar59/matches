<?php

namespace Modules\Purchases\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PurchasedProductsSubUnits extends Model
{
    use HasFactory;

    protected $table="purchased_products_subunits";
    protected $fillable = ['purchased_products_id','sub_unit','sub_unit_quantity'];

    protected static function newFactory()
    {
        return \Modules\Purchases\Database\factories\PurchasedProductsSubUnitsFactory::new();
    }
}

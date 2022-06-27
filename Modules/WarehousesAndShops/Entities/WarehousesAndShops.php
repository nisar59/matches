<?php

namespace Modules\WarehousesAndShops\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehousesAndShops extends Model
{
    use HasFactory;

    protected $fillable = ['name','type'];
    protected $table='warehousesandshops';
    protected static function newFactory()
    {
        return \Modules\WarehousesAndShops\Database\factories\WarehousesAndShopsFactory::new();
    }
}

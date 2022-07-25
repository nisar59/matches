<?php

namespace Modules\Purchases\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Purchases\Entities\PurchasedProductsSubUnits;
use Modules\Products\Entities\Products;

class PurchasedProducts extends Model
{
    use HasFactory;

    protected $table="purchased_products";
    protected $fillable = ["purchase_order_id","transfer_id","warehousesandshops_id","type","product_id","unit_cost","quantity","available_quantity","sold_quantity","transfer_quantity","total_product_cost","parent_id"];
    
    protected static function newFactory()
    {
        return \Modules\Purchases\Database\factories\PurchasedProductsFactory::new();
    }

    public static function AddPurchasedProAndSubUnits($data)
    {
        $ppsbu=[];
       foreach(self::purchasedproducts($data) as $pp){
        $npp=self::create($pp);
        if(isset($data['subunits']) && $data['subunits']!=null){
        foreach($data['subunits'][$npp->product_name] as $key=> $sbu){
            PurchasedProductsSubUnits::create([
                    "purchased_products_id"=>$npp->id,
                    "sub_unit"=>$sbu,
                    "sub_unit_quantity"=>$data['subunitsquantity'][$npp->product_name][$key],
            ]);
                }
            }

       }


       return true;
    }

    protected static function purchasedproducts($purpro)
    {
        $data=[];
        foreach($purpro['product'] as $key=> $pp){
            $data[]=[
                "purchase_order_id"=>$purpro['poi'],
                "warehousesandshops_id"=>$purpro['warehousesandshops_id'][$key],
                "type"=>"purchase",
                "product_id"=>$pp,
                "unit_cost"=>$purpro['price'][$key],
                "quantity"=>$purpro['quantity'][$key],
                "available_quantity"=>$purpro['quantity'][$key],
                "total_product_cost"=>$purpro['pronet'][$key],
            ];
        }
        return $data;
    }


    public function PurchasedProductsSBU()
    {
        return $this->hasMany(PurchasedProductsSubUnits::class, 'purchased_products_id');
    }

    public function ProductRel()
    {
        return $this->hasOne(Products::class,'id','product_id');
    }


    public static function boot() {
        parent::boot();
        self::deleting(function($pp) { // before delete() method call this
             $pp->PurchasedProductsSBU()->each(function($ppsbu) {
                $ppsbu->delete(); // <-- direct deletion
             });
             // do the rest of the cleanup...
        });
    }


}

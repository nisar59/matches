<?php

namespace Modules\Purchases\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Contacts\Entities\Contacts;
use Modules\Purchases\Entities\PurchasedProducts;
use Modules\Transactions\Entities\Transactions;

class Purchases extends Model
{
    use HasFactory;

    protected $table="purchases";
    protected $fillable = [
        'vendor',
        'order_date',
        'reference_no',
        'total_items',
        'gross_total',
        'purchase_total',
        'payment_amount',
        'due',
        'payment_status',
        'discount_type',
        'discount_value',
        'net_discount',
        'shipping_status',
        'shipping_address',
        'shipping_charges',
        'shipping_detail',
        'added_by',
    ];
    
    protected static function newFactory()
    {
        return \Modules\Purchases\Database\factories\PurchasesFactory::new();
    }

    public function VendorDetail()
    {
        return $this->hasOne(Contacts::class,'id','vendor');
    }
    public function PurchasedProducts()
    {
       return $this->hasMany(PurchasedProducts::class,'purchase_order_id');
    }


    public function PurchaseTransaction()
    {
        return $this->hasMany(Transactions::class,'model_id','id');
    }


    public static function boot() {
        parent::boot();
        self::deleting(function($purch) { // before delete() method call this
             $purch->PurchasedProducts()->each(function($pp) {
                $pp->delete(); // <-- direct deletion
             });
             // do the rest of the cleanup...
             $purch->PurchaseTransaction()->each(function($tran)
             {
                $tran->delete();
             });
        });
    }



}




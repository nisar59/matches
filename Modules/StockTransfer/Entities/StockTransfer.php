<?php

namespace Modules\StockTransfer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Purchases\Entities\PurchasedProducts;

class StockTransfer extends Model
{
    use HasFactory;

    protected $table="stocktransfer";
    protected $fillable = [
        "transfer_date",
        "transfer_reference_no",
        "transfer_quantity",
        "transfer_charges",
        "transfer_note",
        "shipping_status",
        "transfer_total",
        "added_by"
    ];
    
    protected static function newFactory()
    {
        return \Modules\StockTransfer\Database\factories\StockTransferFactory::new();
    }

    public function StockTransfered()
    {
       return $this->hasMany(PurchasedProducts::class,'transfer_id');
    }


    public static function boot() {
        parent::boot();
        self::deleting(function($stock) { // before delete() method call this
             $stock->StockTransfered()->each(function($stk) {
                $stk->delete(); // <-- direct deletion
             });

        });
    }


}

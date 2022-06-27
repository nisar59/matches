<?php

namespace Modules\Transactions\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transactions extends Model
{
    use HasFactory;

    protected $fillable = ['model_id','transaction_type','payment_amount','paid_on','method','method_detail','note','due'];

    protected $table="transactions";
    protected static function newFactory()
    {
        return \Modules\Transactions\Database\factories\TransactionsFactory::new();
    }



}

<?php

namespace Modules\Expenses\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Transactions\Entities\Transactions;

class Expenses extends Model
{
    use HasFactory;

    protected $table="expenses";
    protected $fillable = ['expense_category','reference_no','expense_date','payment_status','amount','paid','due','note','added_by'];
    
    protected static function newFactory()
    {
        return \Modules\Expenses\Database\factories\ExpensesFactory::new();
    }

    public function ExpensesTransaction()
    {
        return $this->hasMany(Transactions::class,'model_id','id');
    }

    public static function boot() {
        parent::boot();
        self::deleting(function($expen) { // before delete() method call this
             // do the rest of the cleanup...
             $expen->ExpensesTransaction()->each(function($tran)
             {
                $tran->delete();
             });
        });
    }

}

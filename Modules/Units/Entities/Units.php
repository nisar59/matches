<?php

namespace Modules\Units\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Units extends Model
{
    use HasFactory;

    protected $fillable = ['name'];
    protected $table='units';
    protected static function newFactory()
    {
        return \Modules\Units\Database\factories\UnitsFactory::new();
    }

}

<?php

namespace Modules\Contacts\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contacts extends Model
{
    use HasFactory;

    protected $table='contacts';
    protected $fillable = ['name', 'contact_type','email','phone_no','address'];
    
    protected static function newFactory()
    {
        return \Modules\Contacts\Database\factories\ContactsFactory::new();
    }
}

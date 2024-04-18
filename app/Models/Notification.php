<?php

namespace App\Models;

//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    //use HasFactory;
    

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'readed' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $fillable = ['icon', 'text', 'readed', 'alert', 'codigo'];
    
}

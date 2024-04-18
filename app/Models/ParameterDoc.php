<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterDoc extends Model
{
    use HasFactory;

    protected $fillable = [
        'flag_red',
        'flag_yellow',
        'flag_green'
    ];
}

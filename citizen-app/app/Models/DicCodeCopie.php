<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DicCodeCopie extends Model
{
    use HasFactory;

    protected $fillable=[
        "lieu",
        "code"
    ];
}

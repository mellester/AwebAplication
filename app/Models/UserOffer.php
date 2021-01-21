<?php

namespace App\Models;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOffer extends Model
{
    use HasFactory;
    public static function getDatabaseBuilder()
    {
        return function (Blueprint $table) {
            $table->id();
            $table->integer('price')->unsigned();
        };
    }
}

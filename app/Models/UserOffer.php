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
            $table->foreignId('product_id')->index()->constrained();
            $table->foreignId('user_id')->index()->constrained('users');
            $table->integer('price')->unsigned();
            $table->timestamps();
        };
    }

    protected $fillable = ['price', 'user_id'];
    public const ValidatorRules = array(
        'price' => 'required | numeric',
    );

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}

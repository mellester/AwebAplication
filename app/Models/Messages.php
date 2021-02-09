<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;

class Messages extends Model
{
    use HasFactory;
    public static function getDatabaseBuilder()
    {
        return function (Blueprint $table) {
            $table->id();
            $table->bigInteger('from_user_id')->unsigned()->nullable();
            $table->bigInteger('to_user_id')->unsigned();
            $table->foreign('to_user_id')->references('id')->on('users')
                ->onDelete('cascade');
            $table->json('message');
            $table->timestamps();
        };
    }
    protected $fillable = [
        'from_user_id', 'to_user_id', 'message'
    ];

    /**
     * A message belong to a user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

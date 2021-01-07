<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Product extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->text('permissions');
            $table->timestamps();
        });
        Schema::create('role_user', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('role_id')->unsigned();
            $table->primary(['user_id', 'role_id']);
        });
        Schema::table('role_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name')->unique();
            $table->text('description');
            $table->integer('price');
            $table->integer('user_id')->unsigned();
            // if (config('product.review')) {
            $table->date('reviewed_at')->nullable();
            $table->integer('reviewed_by')->unsigned()->nullable();
            // }
            $table->timestamps();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            // $table->foreign('product_category_id')->references('id')->on('categories')->onDelete('cascade');
            if (config('market.product.review')) {
                $table->foreign('reviewed_by')->references('id')->on('users')->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('products');
        
    }
}

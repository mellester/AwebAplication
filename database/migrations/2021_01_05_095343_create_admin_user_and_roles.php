<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\UserType;

class CreateAdminUserAndRoles extends Migration
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
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('role_id')->unsigned();
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
            $table->json('data');
            $table->bigInteger('user_id')->unsigned();
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
        $data = [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),

        ];
        $user = User::firstOrNew($data);
        //$user->role = UserType::Administrator;
        $user->save();


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        User::where('email', 'admin@example.com')->delete();
        if (Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
        }
        Schema::dropIfExists('roles');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('products');
        
    }
}

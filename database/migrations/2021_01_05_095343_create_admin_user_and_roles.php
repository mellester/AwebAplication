<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Enums\productStatus;
use App\Enums\UserType;
use App\Models\Roles;

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
            $table->text('permissions')->nullable();
            $table->timestamps();
        });
        Schema::create('roles_user', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('roles_id')->unsigned();
            $table->primary(['user_id', 'roles_id']);
            $table->timestamps();
        });
        Schema::table('roles_user', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('roles_id')->references('id')->on('roles')->onDelete('cascade');
        });
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('photo')->nullable();
            $table->string('name')->unique();
            $table->text('description');
            $table->integer('price');
            $table->json('data');
            $table->string('status', 30)->default(productStatus::notPublished);
            $table->json('offer')->nullable();
            $table->timestamp('offer_at')->nullable();
            $table->timestamp('offer_until')->nullable();
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

        $roles = UserType::getKeys();
        $data = [];
        foreach ($roles as $roleName) {
            array_push($data, [
                'name' => $roleName,
                'slug' => UserType::getValue($roleName),
            ]);
        }
        Roles::insert($data);

        $data = [
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),

        ];
        $user = User::firstOrNew($data);
        $role = Roles::where('slug', UserType::Administrator)->first();
        $role1 = Roles::create([
            'name' => 'test,test , test',
            'slug' => 5,
        ]);
        $user->save();
        $user->roles()->save($role);
        $user->roles()->save($role1);
        //$user->role = UserType::Administrator;

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

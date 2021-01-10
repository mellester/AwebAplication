<?php

use App\Http\Resources\DashboardProduct;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MakeDBviews extends Migration
{
    const viewName = DashboardProduct::viewName;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $viewSQLQuery = DashboardProduct::viewSQLQuery;
        $viewName = self::viewName;
        DB::statement("DROP VIEW IF EXISTS $viewName ");
        DB::statement("CREATE VIEW  $viewName  AS $viewSQLQuery");  
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW IF EXISTS " . self::viewName);
    }
}

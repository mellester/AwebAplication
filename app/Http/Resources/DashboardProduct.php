<?php

namespace App\Http\Resources;

use App\Http\Middleware\CacheMiddleware;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Parent_;

class DashboardProduct extends JsonResource
{
    // The below 2 define a MYSQL stament that is used by a migration file to vreate views in the Database
    const viewName = "DashboardProduct";
    const viewSQLQuery = <<<SQL
            SELECT 
              u.id,
              u.name,
              u.email,
              u.created_at,
              u.email_verified_at,
              u.profile_photo_path,
              COUNT(p.user_id) AS productsTotal
            FROM 
                users as u
            LEFT OUTER JOIN products AS p
            ON u.id = p.user_id
            GROUP BY u.id;
    SQL;

    public function __construct($a)
    {
        parent::__construct($a);
    
    }
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $mid = new CacheMiddleware();
        $id = $this->id;
        $viewName = self::viewName;
        return $mid->handle($request, function () use ($id, $viewName){
            return (DB::table($viewName)->where('id', $id)->first());
        } , 300);
    }
}

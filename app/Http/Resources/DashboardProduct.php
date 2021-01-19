<?php

namespace App\Http\Resources;

use App\Http\Middleware\CacheMiddleware;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Parent_;
use App\Enums\productStatus;

class DashboardProduct extends JsonResource
{
    // The below 2 define a MYSQL stament that is used by a migration file to vreate views in the Database
    const viewName = "DashboardProduct";
    private static string $notPublished = productStatus::notPublished;
    public static $viewSQLQuery = <<<SQL
            SELECT 
              u.id,
              u.name,
              u.email,
              u.created_at,
              u.email_verified_at,
              u.profile_photo_path,
              COUNT(p.user_id) AS productsTotal,
              COUNT(if(p.status != 'notPublished', p.id, NULL)) as productsPublished,
              JSON_ARRAY(GROUP_CONCAT( DISTINCT roles.name)) as roles
            FROM 
                users as u
            LEFT OUTER JOIN products AS p ON u.id = p.user_id
            LEFT JOIN roles_user on roles_user.user_id = u.id
            LEFT JOIN roles on roles_user.user_id = roles.id
            GROUP BY u.id;
            SQL;
    // public static $test4 = " Hello there %s." . "hi";

    // public static $test1 = sprintf(" Hello there %s.", "hi");
    // public static $test2 = sprintf(" Hello there %s.", $notPublished);
    // public static $test3 = sprintf(" Hello there %s.", productStatus::notPublished);

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
        $id = $this->id;
        $viewName = self::viewName;
        $ret = (DB::table($viewName)->where('id', $id)->first());
        dd($ret);
        $ret->roles = json_decode(',', $ret->roles);
        return $ret;
    }
}

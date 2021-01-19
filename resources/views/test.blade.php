


<?php

use Illuminate\Support\Facades\DB;

$viewSQLQuery = <<<SQL
WITH subq2 as (
    WITH subq as (
    SELECT distinct users.id as id, roles.name as name
    FROM 
        users 
    LEFT  JOIN   roles_user on roles_user.user_id = users.id
    LEFT  JOIN  roles on roles_user.roles_id = roles.id
    )
    SELECT
    u.id,
    u.name,
    u.email,
    u.created_at,
    u.email_verified_at,
    u.profile_photo_path,
    --   COUNT(p.user_id) AS productsTotal,
    --   COUNT(if(p.status != 'notPublished', p.id, NULL)) as productsPublished,
    JSON_ARRAYAGG( subq.name ) as roles 
    From subq 
    LEFT OUTER join users as u ON u.id = subq.id
    GROUP BY subq.id
) 
SELECT     u.id,
    u.name,
    u.email,
    u.created_at,
    u.email_verified_at,
    u.profile_photo_path,
    MIN(u.roles) as roles,
      COUNT(p.user_id) AS productsTotal,
      COUNT(if(p.status != 'notPublished', p.id, NULL)) as productsPublished
FROM subq2 as u
LEFT OUTER JOIN products AS p ON u.id = p.user_id
GROUP BY u.id
;
SQL;
dump('tets');
dd(DB::select(DB::raw($viewSQLQuery)));
?>



<?php

use Illuminate\Support\Facades\DB;

$viewSQLQuery = <<<SQL
with `subq` as (
    /* select#2 */ select 
    `awebaplication`.`u`.`id` AS `id`,
    `awebaplication`.`u`.`name` AS `name`,
    `awebaplication`.`u`.`email` AS `email`,
    `awebaplication`.`u`.`created_at` AS `created_at`,
    `awebaplication`.`u`.`email_verified_at` AS `email_verified_at`,
    `awebaplication`.`u`.`profile_photo_path` AS `profile_photo_path`,
    json_arrayagg(`awebaplication`.`roles`.`name`) AS `roles`
    from `awebaplication`.`users` `u` 
    left join `awebaplication`.`roles_user` 
    on((`awebaplication`.`roles_user`.`user_id` = `awebaplication`.`u`.`id`)) 
    left join `awebaplication`.`roles` 
    on((`awebaplication`.`roles`.`id` = `awebaplication`.`roles_user`.`roles_id`)) 
    where true 
    group by `awebaplication`.`u`.`id`) 
    /* select#1 */ select `subq`.`id` AS `id`,`subq`.`name` AS `name`,`subq`.`email` AS `email`,
    `subq`.`created_at` AS `created_at`,
    `subq`.`email_verified_at` AS `email_verified_at`,
    `subq`.`profile_photo_path` AS `profile_photo_path`,
    `subq`.`roles` AS `roles`,
    count(`awebaplication`.`p`.`user_id`) AS `productsTotal`,
    count(if((`awebaplication`.`p`.`status` <> 'notPublished'),
    `awebaplication`.`p`.`id`,NULL)) AS `productsPublished`
     from `subq` left join `awebaplication`.`products` `p` on((`awebaplication`.`p`.`user_id` = `subq`.`id`)) where true group by `subq`.`id`
;
SQL;

$viewSUBSQLQuery = <<<SQL
WITH subq as (   
    SELECT 
    u.id,
    u.name,
    u.email,
    u.created_at,
    u.email_verified_at,
    u.profile_photo_path,
    JSON_ARRAYAGG( roles.name ) as roles
    FROM users as u
    LEFT  JOIN   roles_user on roles_user.user_id = u.id
    LEFT  JOIN  roles on roles_user.roles_id = roles.id
    GROUP BY u.id
 ) SELECT subq.*,
    COUNT(p.user_id) AS productsTotal,
    COUNT(if(p.status != 'notPublished', p.id, NULL)) as productsPublished
    FROM subq
    LEFT OUTER JOIN products AS p ON subq.id = p.user_id
    GROUP BY subq.id
    ;
SQL;
dump('tets');
dd(DB::select(DB::raw($viewSUBSQLQuery)));
dd(DB::select(DB::raw($viewSQLQuery)));
?>
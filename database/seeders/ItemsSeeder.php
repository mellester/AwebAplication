<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Load a json of DND 5e itmems
        $string = file_get_contents("database/seeders/items-base.json");
        $json_a = json_decode($string,true);
        $toInsert = [];
        $time    = Carbon::now();
        foreach ($json_a['baseitem'] as $key => $data){
            $user = null;
            if ($data['source'] == 'PHB') {
                $user = User::where('name', 'admin')->first();
            }
            else  {
                $user = User::firstOrCreate( ['name' => $data['source']],
                ['email' => $data['source'] . '@example.com',
                 'password' => Hash::make('password') ]);
            }
            $name = $data['name']; unset($data['name']);
            $rarity = $data['rarity'] != "none" ? $data['rarity'] : 'normal';
            $description = "A $rarity $name";

            $price = $data['value'] ?? -1;
            if (isset($data['entries']) && getType($data['entries'][0]) == getType("")) {
                $description = implode('\n',$data['entries']);
            }
            array_push ( $toInsert, array(
                'user_id' => $user->id,
                'name' => $name,
                'data' => json_encode($data),
                'price' => $price,
                'description' => $description,
                'created_at' => $time
            ));
            $time = $time->addHour(-1);
            //echo  $key . ':' . print_r($itemData) . '\n';
        }
        Product::insert($toInsert);
    }
}

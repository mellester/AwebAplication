<?php

namespace Database\Seeders;

use App\Enums\Duration;
use App\Enums\PriceOptions;
use App\Enums\productStatus;
use App\Events\ProductPublished;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        $json_a = json_decode($string, true);
        $toInsert = [];
        $time    = Carbon::now();
        foreach ($json_a['baseitem'] as $key => $data) {
            $user = null;
            if ($data['source'] == 'PHB') {
                $user = User::where('name', 'admin')->first();
            } else {
                $user = User::firstOrCreate(
                    ['name' => $data['source']],
                    [
                        'email' => $data['source'] . '@example.com',
                        'password' => Hash::make('password'),
                        'location' => "{\"city\": \"Groningen\", \"place\": {\"url\": \"https://maps.google.com/?q=9728+HC&ftid=0x47c832a4848f48b3:0xe28d98a0e124414b\", \"icon\": \"https://maps.gstatic.com/mapfiles/place_api/icons/v1/png_71/geocode-71.png\", \"name\": \"9728 HC\", \"types\": [\"postal_code\"], \"geometry\": {\"location\": {\"lat\": 53.19412939999999, \"lng\": 6.5588574}, \"viewport\": {\"east\": 6.560379867134859, \"west\": 6.557681906551855, \"north\": 53.19612391782776, \"south\": 53.19342595724476}}, \"place_id\": \"ChIJs0iPhKQyyEcRS0Ek4aCYjeI\", \"vicinity\": \"Stadsparkwijk\", \"reference\": \"ChIJs0iPhKQyyEcRS0Ek4aCYjeI\", \"utc_offset\": 60, \"adr_address\": \"<span class=\\\"postal-code\\\">9728 HC</span> <span class=\\\"locality\\\">Groningen</span>, <span class=\\\"country-name\\\">Nederland</span>\", \"obfuscated_type\": [], \"formatted_address\": \"9728 HC Groningen, Nederland\", \"html_attributions\": [], \"address_components\": [{\"types\": [\"postal_code\"], \"long_name\": \"9728 HC\", \"short_name\": \"9728 HC\"}, {\"types\": [\"sublocality_level_1\", \"sublocality\", \"political\"], \"long_name\": \"Stadsparkwijk\", \"short_name\": \"Stadsparkwijk\"}, {\"types\": [\"locality\", \"political\"], \"long_name\": \"Groningen\", \"short_name\": \"Groningen\"}, {\"types\": [\"administrative_area_level_2\", \"political\"], \"long_name\": \"Groningen\", \"short_name\": \"Groningen\"}, {\"types\": [\"administrative_area_level_1\", \"political\"], \"long_name\": \"Groningen\", \"short_name\": \"GR\"}, {\"types\": [\"country\", \"political\"], \"long_name\": \"Nederland\", \"short_name\": \"NL\"}], \"utc_offset_minutes\": 60}, \"latlng\": {\"lat\": 53.19412939999999, \"lng\": 6.5588574}, \"country\": \"NL\", \"zipcode\": \"9728 HC\"}",
                    ]
                );
            }
            $name = $data['name'];
            unset($data['name']);
            $rarity = $data['rarity'] != "none" ? $data['rarity'] : 'normal';
            $description = "A $rarity $name";

            $price = $data['value'] ?? -1;
            if (isset($data['entries']) && getType($data['entries'][0]) == getType("")) {
                $description = implode('\n', $data['entries']);
            }
            $tmp = array(
                'user_id' => $user->id,
                'name' => $name,
                'data' => json_encode($data),
                'price' => $price,
                'description' => $description,
                'created_at' => $time
            );
            array_push($toInsert, $tmp);

            $time = $time->addHour(-1);
            //echo  $key . ':' . print_r($itemData) . '\n';
        }
        Product::insert($toInsert);
        $groups = Product::get()->groupBy('user_id')->map(function ($deal) {
            return $deal->take(3);
        });
        foreach ($groups as $products) {
            foreach ($products as $product) {
                $product->offer = json_encode(array(
                    "timeOffer" => true,
                    "timeData" => [6, Duration::Hour],
                    "priceOffer" => true,
                    "priceData" => PriceOptions::SuggestPrice,
                    "PremOffer" => false,
                ));
                $product->save();
            }
        }
    }
}

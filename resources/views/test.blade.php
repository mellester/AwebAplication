


<?php 
// $faker = Faker\Factory::create();
// use App\Models\User;
// $data = [
//     'id' => 1,
//     'name' => 'john',
//     'email' => 'john@exmaple.com',
//     'password' => \Hash::make('password'),
// ];
// $user = User::firstOrCreate($data);
function CURL($url) {
$ch = curl_init();

// set url
curl_setopt($ch, CURLOPT_URL, $url);

//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// $output contains the output string
$output = curl_exec($ch);

// close curl resource to free up system resources
curl_close($ch); 
return $output;   
};
$url = 'http://localhost:9515/wd/hub/status';
dump(CURL($url));

?>
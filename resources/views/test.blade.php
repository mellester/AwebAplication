
<?php 
$faker = Faker\Factory::create();
use App\Models\User;
$data = [
    'id' => 1,
    'name' => 'john',
    'email' => 'john@exmaple.com',
    'password' => \Hash::make('password'),
];
$user = User::firstOrCreate($data);

?>
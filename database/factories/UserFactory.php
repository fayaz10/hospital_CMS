<?php

use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/
$fakerFA = FakerFactory::create('fa_IR');

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});


$factory->define(App\Models\Receptionist\Doctor::class, function (Faker $faker) use ($fakerFA) {
    return [
        'first_name' => $fakerFA->firstName,
        'last_name' => $fakerFA->lastName,
        'email' => $fakerFA->unique()->safeEmail,
        'specialist' => $fakerFA->sentence(3),
        'visit_fee' => 200,
        'currency_id' => 1,
        'registrar_id' => 1,
    ];
});

$factory->define(App\Models\Receptionist\Patient::class, function (Faker $faker) use ($fakerFA) {
    return [
        'name' => $fakerFA->name(),
        'record_no' => $faker->unique()->randomNumber,
        'age' => $fakerFA->numberBetween(1,99),
        'phone_no' => $fakerFA->phoneNumber,
        'tazkira' => $fakerFA->randomNumber(),
        'registrar_id' => 1,
    ];
});

$factory->define(App\Models\Receptionist\Visit::class, function (Faker $faker) use ($fakerFA) {
    return [
        'patient_id' => $fakerFA->numberBetween(1,150),
        'doctor_id' => $fakerFA->numberBetween(1,150),
        'cashier_id' => $fakerFA->numberBetween(1,5),
        'discount' => $fakerFA->randomElement([10, 15,20,25,30,35,40,50]),
    ];
});

$factory->define(App\Models\Pharmacist\Medicine::class, function (Faker $faker) use ($fakerFA) {
    return [
        'name' => $faker->sentence(3, true),
        'milligram' => $faker->numberBetween(150, 1000),
        'company' => $faker->company,
        'unit_id' => $faker->randomElement([1, 2, 3]),
        'type_id' => $faker->randomElement([1, 2, 3, 4, 5, 6]),
    ];
});

$factory->define(App\Models\Pharmacist\MedicineStock::class, function (Faker $faker) use ($fakerFA) {
    return [
        'medicine_id' => $faker->numberBetween(1, 1000),
        'quantity' => $faker->numberBetween(150, 800),
        'unit_id' => $faker->randomElement([1, 2, 3, 4]),
        'unit_price' => $faker->numberBetween(50, 250),
        'currency_id' => 1,
        'registrar_id' => 1,
    ];
});

$factory->define(App\Models\Pharmacist\MedicinePuchase::class, function (Faker $faker) use ($fakerFA) {
    return [
        'suppliers' => $faker->company,
        'purchase_date' => $faker->date(),
        'registrar_id' => 1,
    ];
});

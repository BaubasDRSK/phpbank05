<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $faker = Faker::create('lt_LT');

        DB::table('users')->insert([
            'name' => 'Bebras',
            'email' => 'bebras@gmail.com',
            'password' => Hash::make('123'),
        ]);
        DB::table('users')->insert([
            'name' => 'Briedis',
            'email' => 'briedis@gmail.com',
            'password' => Hash::make('123'),
        ]);

        foreach (range(1, 20) as $_) {
            DB::table('clients')->insert([
                'fname' => $faker->firstName,
                'lname' => $faker->lastName,
                'pid' => $faker->regexify('/^(3[0-9]{2}|4[0-9]{2}|6[0-9]{2}|5[0-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/'),
                'info' => $faker->sentence()
            ]);
        }

        foreach (range(1, 70) as $_) {
            DB::table('accounts')->insert([
                'client_id' => $faker->numberBetween(1, 20),
                'iban' => generateLithuanianIBAN(),
                //'iban' => $faker->iban('LT'),
                'balance' => $faker->randomFloat(2, 0, 100000)
            ]);
        }

        //  PID regex('/^(3[0-9]{2}|4[0-9]{2}|6[0-9]{2}|5[0-9]{2})(0[1-9]|1[0-2])(0[1-9]|[12][0-9]|3[01])\d{4}$/', $pid)){


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}

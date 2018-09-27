<?php

use Faker\Factory;
use Illuminate\Database\Seeder;

class HackathonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        $users = [
            $this->makeBtpPerson(1, 'kyle'),
            $this->makeBtpPerson(2, 'wouter'),
            $this->makeBtpPerson(3, 'roeland'),
            $this->makeBtpPerson(4, 'heath'),
            $this->makeBtpPerson(5, 'turner'),
            $this->makeBtpPerson(6, 'nathan'),
            $this->makeBtpPerson(7, 'elliot'),
            $this->makeBtpPerson(8, 'carla')
        ];

        DB::table('users')->insert($users);

        DB::table('hackathons')->insert([
            ['id' => 1, 'title' => 'Bobs Hackathon 2020', 'user_id' => 3],
            ['id' => 2, 'title' => 'Hkrs Unite', 'user_id' => 6],
            ['id' => 3, 'title' => 'Cheetos Hackies', 'user_id' => 8]
        ]);

        for($i = 1; $i < 11; $i++) {

            DB::table('ideas')->insert([
                ['id' => $i, 'hackathon_id' => 1, 'user_id' => rand(1,8), 'title' => $faker->sentence(), 'description' => $faker->paragraph()]
            ]);



            for($x = 1; $x < 6; $x++) {
                DB::table('features')->insert([
                    ['id' => (($i * 10) + $x), 'idea_id' => $i, 'user_id' => rand(1,8), 'title' => $faker->sentence()]
                ]);
            }
        }

        foreach($users as $user) {
            DB::table('idea_votes')->insert(['idea_id' => rand(1,5), 'user_id' => $user['id']]);
            DB::table('idea_votes')->insert(['idea_id' => rand(6,10), 'user_id' => $user['id']]);
        }
    }

    private function makeBtpPerson(int $id, string $name)
    {
        return [
            'id' => $id,
            'name' => ucwords($name),
            'email' => "$name@bythepixel.com",
            'password' => 'bythepixel'
        ];
    }
}

<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            "name" => "Marco Consiglio",
            "email" => "mrccnsgl@gmail.com"
        ]);
        factory(User::class, 2)->create();
    }
}

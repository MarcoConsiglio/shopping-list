<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (! User::where("email", "mrccnsgl@gmail.com")->exists())
            User::factory()->create([
                "name" => "Marco Consiglio",
                "email" => "mrccnsgl@gmail.com",
                "password" => Hash::make("password")
            ]);
        User::factory()->count(2)->create();
    }
}

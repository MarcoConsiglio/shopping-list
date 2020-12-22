<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{User, ShoppingList};

class ShoppingListsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        foreach($users as $user)
        {
            $user->shopping_lists()
                 ->saveMany(
                    factory(ShoppingList::class, 3)->make()
                 );
        }
    }
}
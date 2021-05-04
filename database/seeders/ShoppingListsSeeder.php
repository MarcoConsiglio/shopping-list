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
        if($users)
            foreach($users as $user)
            {
                $user->shoppingLists()
                     ->saveMany(
                        ShoppingList::factory()->count(3)->make()
                     );
            }
        else
            $this->command->alert("There is no user to assign a shopping list.");
    }
}

<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{ShoppingList, Product};

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $shopping_lists = ShoppingList::all();
        if($shopping_lists)
            foreach($shopping_lists as $shopping_list)
            {
                $shopping_list->products()
                            ->saveMany(
                                Product::factory()->count(12)->make()
                            );
            }
        else
            $this->command->alert("There is no shopping list to assign products.");
    }
}

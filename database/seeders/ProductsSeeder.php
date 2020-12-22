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
        foreach($shopping_lists as $shopping_list)
        {
            $shopping_list->products()
                          ->saveMany(
                              factory(Product::class, 12)->make()
                          );
        }
    }
}

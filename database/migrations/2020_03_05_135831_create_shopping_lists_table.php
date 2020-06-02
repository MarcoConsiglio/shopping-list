<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppingListsTable extends Migration
{
    use SQLiteMigration;

    private $table_name = "shopping_lists";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopping_lists', function (Blueprint $table) {
            $table->id();
            $table->string("title")->required();
            $table->foreignId('user_id')
                  ->constrained("users")
                  ->onDelete("cascade")
                  ->onUpdate("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if($this->isSQLite())
        {
            Schema::table($this->table_name, function(Blueprint $table){
                $table->dropforeign(["user_id"]);
            });
        }
        Schema::dropIfExists('shopping_lists');

    }
}

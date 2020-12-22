<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\SQLiteMigrations;

class CreateShoppingListsTable extends Migration
{
    use SQLiteMigrations;

    /**
     * Nome della tabella.
     *
     * @var string
     */
    private $table_name = "shopping_lists";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
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

        Schema::table($this->table_name, function(Blueprint $table){
            if(!$this->isSQLiteDatabase())
                $table->dropforeign(["user_id"]);
        });
        Schema::dropIfExists('shopping_lists');

    }
}

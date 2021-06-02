<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Database\SQLiteMigrations;

class CreateProductsTable extends Migration
{
    use SQLiteMigrations;

    private $table_name = "products";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table_name, function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("brand")->nullable()->default(null);
            $table->float("price")->nullable()->default(null);
            $table->float('quantity')->unsigned()->nullable()->default(1);
            $table->float("cart_quantity")->unsigned()->nullable()->default(0);
            $table->string("measure")->nullable()->default(null);
            $table->string("note")->nullable()->default(null);
            $table->foreignId("shopping_list_id")
                  ->constrained("shopping_lists")
                  ->onDelete("cascade")
                  ->onUpdate("cascade");
            $table->timestamps();
            $table->softDeletes();
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
            Schema::table($this->table_name, function(Blueprint $table){
                if(!$this->isSQLiteDatabase())
                    $table->dropforeign(["shopping_list_id"]);
            });
        });
        Schema::dropIfExists($this->table_name);
    }
}

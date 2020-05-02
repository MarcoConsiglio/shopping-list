<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
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
                $table->dropforeign(["shopping_list_id"]);
            });
        }
        Schema::dropIfExists($this->table_name);
    }
}

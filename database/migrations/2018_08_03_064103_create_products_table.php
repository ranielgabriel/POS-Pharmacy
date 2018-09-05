<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('manufacturer_id');
            $table->string('brand_name');
            $table->string('status')->default('In-stock');
            $table->decimal('market_price', 10, 2)->default(0);
            $table->decimal('special_price', 10, 2)->default(0);
            $table->decimal('walk_in_price', 10, 2)->default(0);
            $table->decimal('promo_price', 10, 2)->default(0);
            $table->decimal('distributor_price', 10, 2)->default(0);
            $table->integer('drug_type_id');
            $table->integer('generic_name_id');
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
        Schema::dropIfExists('products');
    }
}

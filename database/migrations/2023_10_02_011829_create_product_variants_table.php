<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductVariantsTable extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shoe_id');
            $table->string('color');
            $table->string('size');
            $table->integer('stock')->default(0);
            $table->timestamps();
    
            $table->index('shoe_id');
        });
    }
    

    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}

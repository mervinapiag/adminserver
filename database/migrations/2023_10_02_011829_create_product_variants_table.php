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
            $table->unsignedBigInteger('product_id');
            $table->string('product_type');
            $table->string('color')->default('N/A');
            $table->string('size')->default('N/A');
            $table->integer('stock')->default(0);
            $table->timestamps();

            $table->index(['product_id', 'product_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}

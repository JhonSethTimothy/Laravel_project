<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('borrowed_items', function (Blueprint $table) {
            $table->id(); // Code (automatic)
            $table->date('date');
            $table->string('borrower_name');
            $table->string('equipment_name');
            $table->integer('equipment_quantity');
            $table->string('product_name');
            $table->integer('product_quantity');
            $table->string('location');
            $table->string('purpose');
            $table->time('borrowed_time');
            $table->string('returned_item')->nullable();
            $table->integer('quantity_returned')->nullable();
            $table->time('returned_time')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('borrowed_items');
    }
};

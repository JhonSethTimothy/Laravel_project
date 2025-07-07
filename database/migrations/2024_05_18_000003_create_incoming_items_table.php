<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('incoming_items', function (Blueprint $table) {
            $table->id(); // Code (automatic)
            $table->date('date');
            $table->string('serial_number');
            $table->string('model');
            $table->string('brand');
            $table->string('item_description');
            $table->integer('quantity');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('incoming_items');
    }
};

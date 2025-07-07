<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('outgoing_items', function (Blueprint $table) {
            $table->id(); // Code (automatic)
            $table->date('date');
            $table->string('client');
            $table->string('location');
            $table->string('purpose');
            $table->string('item_description');
            $table->integer('quantity');
            $table->string('person_in_charge');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('outgoing_items');
    }
};

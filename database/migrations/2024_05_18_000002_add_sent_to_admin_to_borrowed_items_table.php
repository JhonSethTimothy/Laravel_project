<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('borrowed_items', function (Blueprint $table) {
            $table->boolean('sent_to_admin')->default(false)->after('remarks');
        });
    }

    public function down()
    {
        Schema::table('borrowed_items', function (Blueprint $table) {
            $table->dropColumn('sent_to_admin');
        });
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSentToAdminToIncomingItemsTable extends Migration
{
    public function up(): void
    {
        Schema::table('incoming_items', function (Blueprint $table) {
            $table->boolean('sent_to_admin')->default(false);
        });
    }

    public function down(): void
    {
        Schema::table('incoming_items', function (Blueprint $table) {
            $table->dropColumn('sent_to_admin');
        });
    }
}

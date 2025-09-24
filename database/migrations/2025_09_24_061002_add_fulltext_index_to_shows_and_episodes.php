<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->fullText('title');
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->fullText('title');
        });
    }

    public function down()
    {
        Schema::table('shows', function (Blueprint $table) {
            $table->dropFullText(['title']);
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->dropFullText(['title']);
        });
    }
};

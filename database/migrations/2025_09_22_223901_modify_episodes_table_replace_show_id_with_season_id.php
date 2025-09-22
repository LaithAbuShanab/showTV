<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            if (Schema::hasColumn('episodes', 'season_id')) {
                $table->dropForeign(['season_id']);
                $table->dropColumn('season_id');
            }

            if (Schema::hasColumn('episodes', 'show_id')) {
                $table->dropForeign(['show_id']);
                $table->dropColumn('show_id');
            }
        });

        Schema::table('episodes', function (Blueprint $table) {
            $table->foreignId('season_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->after('episode_number');
        });
    }


    public function down(): void
    {
        Schema::table('episodes', function (Blueprint $table) {
            $table->dropForeign(['season_id']);
            $table->dropColumn('season_id');

            $table->foreignId('show_id')
                ->nullable()
                ->constrained()
                ->onDelete('cascade')
                ->after('episode_number');
        });
    }
};

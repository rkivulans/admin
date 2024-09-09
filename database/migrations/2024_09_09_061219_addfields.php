<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('max_emails')->nullable();
            $table->integer('max_aliases')->nullable();
            $table->integer('max_storage')->nullable();
            $table->integer('max_domains')->nullable();
        });
    }
};

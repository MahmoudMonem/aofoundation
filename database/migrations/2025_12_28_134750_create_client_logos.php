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
        Schema::create('client_logos', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Client/Company name');
            $table->string('logo')->comment('Path to logo image');
            $table->tinyInteger('row')->default(1)->comment('Which row to display: 1 or 2');
            $table->integer('sort_order')->default(0)->comment('Order within the row');
            $table->boolean('is_active')->default(true)->comment('Whether to show this logo');
            $table->timestamps();

            $table->index(['row', 'sort_order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('client_logos');
    }
};
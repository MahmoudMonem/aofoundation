<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_contents', function (Blueprint $table) {
            $table->id();
     $table->string('key')->unique()->comment('Unique identifier for the content');
            $table->string('type', 50)->default('text')->comment('Content type: text, textarea, image, url, email');
            $table->text('value')->nullable()->comment('The actual content value');
            $table->string('label')->comment('Human readable label for admin panel');
            $table->string('section', 100)->nullable()->comment('Section grouping for organization');
            $table->text('description')->nullable()->comment('Description/help text for admin');
            $table->boolean('is_active')->default(true)->comment('Whether content is active');
            $table->integer('sort_order')->default(0)->comment('Order for display in admin');
            $table->timestamps();

            // Add indexes for performance
            $table->index(['section', 'sort_order']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_contents');
    }
}

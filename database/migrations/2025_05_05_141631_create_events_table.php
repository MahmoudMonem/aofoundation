<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title_en', 150)->nullable();
            $table->string('title_ar', 150)->nullable();

            $table->text('short_desc_en')->nullable();
            $table->text('short_desc_ar')->nullable();


            $table->text('desc_en')->nullable();
            $table->text('desc_ar')->nullable();

            $table->string('cover')->nullable();
            $table->string('logo')->nullable();

            $table->string('thumbnail')->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('available')->default(false);

            $table->string('slug')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}

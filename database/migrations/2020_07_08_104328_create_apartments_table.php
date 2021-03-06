<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('title');
            $table->text('description');
            $table->unsignedTinyInteger('rooms_number');
            $table->unsignedTinyInteger('beds_number');
            $table->unsignedTinyInteger('bathrooms_number');
            $table->unsignedSmallInteger('square_meters');
            $table->string('country');
            $table->string('region');
            $table->string('province');
            $table->string('city');
            $table->string('address');
            $table->string('zip_code', 20);
            $table->float('geo_lat', 9, 6);
            $table->float('geo_lng', 9, 6);
            $table->boolean('active')->default(true);
            $table->unsignedBigInteger('views')->nullable();
            $table->string('featured_img');
            $table->timestamps();

            /**
             * Relationships
             */
            $table->foreign('user_id')
                  ->references('id')
                  ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartments');
    }
}

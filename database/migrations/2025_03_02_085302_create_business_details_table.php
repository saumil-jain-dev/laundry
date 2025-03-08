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
        Schema::create('business_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('business_name');
            $table->unsignedInteger('business_type_id');
            $table->string('services');
            $table->text('address_line_1')->nullable();
            $table->text('address_line_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('lattitude')->nullable();
            $table->string('longitude')->nullable();
            $table->longText('about')->nullable();
            $table->string('business_image');
            $table->json('media')->nullable();
            $table->json('store_timings')->nullable();
            $table->json('pricing')->nullable();
            $table->tinyInteger('is_verified')->default(0)->comment('0-Pending, 1-Verified');
            $table->tinyInteger('status')->default(1)->comment('1-Active, 0-Inactive');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_details');
    }
};

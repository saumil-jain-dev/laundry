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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('business_id');
            $table->decimal('total_amount',7,2);
            $table->decimal('gross_amount',7,2)->nullable();
            $table->decimal('discount_amount',7,2)->nullable();
            $table->unsignedBigInteger('diccount_id')->nullable();
            $table->string('coupon_code')->nullable();
            $table->dateTime('pickup_date_time');
            $table->dateTime('drop_date_time');
            $table->longText('address');
            $table->longText('customer_notes')->nullable();
            $table->unsignedBigInteger('canceled_by')->nullable();
            $table->string('cancel_remark')->nullable();
            $table->text('cancel_reason')->nullable();
            $table->enum('status', ['pending', 'accepted', 'pickup', 'ready for dispatch', 'delivered', 'canceled'])
            ->default('pending');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

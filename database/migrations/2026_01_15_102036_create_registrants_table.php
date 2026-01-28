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
        Schema::create('registrants', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->string('first_name', 150);
            $table->string('surname', 150);
            $table->integer('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->integer('marital_status')->nullable();
            $table->integer('nationality_id');
            $table->string('phone_number', 50);
            $table->string('whatsapp_number', 50)->nullable();
            $table->string('email');
            $table->text('address');
            $table->integer('residence_country_id');
            $table->string('languages_spoken');
            $table->string('emergency_contacts_name');
            $table->string('emergency_contacts_relationship', 50)->nullable();
            $table->string('emergency_contacts_phone_number', 50)->nullable();
            $table->boolean('disability')->default(false);
            $table->text('special_needs')->nullable();
            $table->enum('confirmed', ['Yes', 'No'])->default('No');
            $table->string('token', 20);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('online_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('reg_id');
            $table->integer('accommodation_type')->nullable();
            $table->decimal('accommodation_fee', 10, 2)->default(0.00);
            $table->string('special_food')->nullable();
            $table->string('payment_mode')->nullable();
            $table->string('transaction_no')->nullable();
            $table->string('reference')->nullable();
            $table->decimal('amount_paid', 10, 2)->nullable();
            $table->date('date_paid')->nullable();
            $table->string('comment')->nullable();
            $table->string('approved')->nullable();
            $table->date('approved_at')->nullable();
            $table->decimal('event_total_fee', 10 , 2)->nullable();
            $table->string('customer_id')->nullable();
            $table->tinyInteger('payment_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrants');
        Schema::dropIfExists('online_payments');
    }
};

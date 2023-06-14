<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('users_id');
            $table->string('name');
            $table->string('email');
            $table->longText('address');
            $table->string('phone');
            $table->string('courier')->nullable();
            $table->integer('total_price');
            $table->string('status')->default('PENDING');
            $table->string('payment')->default('MIDTRANS');
            $table->string('payment_url')->nullable();
            
            $table->timestamps();
            // created_at, updated_at

            $table->softDeletes();
            // deleted_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};

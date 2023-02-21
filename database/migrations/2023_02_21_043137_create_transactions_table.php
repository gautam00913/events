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
            $table->foreignId('user_id')->constrained();
            $table->unsignedInteger('amount');
            $table->unsignedInteger('fees_amount')->default(0);
            $table->unsignedInteger('refunded_amount')->default(0);
            $table->string('account_holder');
            $table->string('account_number');
            $table->string('account_provider');
            $table->timestamp('initiate_at');
            $table->timestamp('refunded_at')->nullable();

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

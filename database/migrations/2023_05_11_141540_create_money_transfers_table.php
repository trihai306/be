<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMoneyTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money_transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['deposit', 'withdrawal', 'order', 'completed_order']);
            $table->decimal('amount');
            $table->string('note');
            $table->string('bank_name')->nullable();
            $table->string('bank_account')->nullable();
            $table->string('number_account')->nullable();
            $table->enum('status', ['pending', 'success', 'failed'])->default('pending');
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
        Schema::dropIfExists('money_transfers');
    }
}

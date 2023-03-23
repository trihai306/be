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
        Schema::create('proxys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('domain');
            $table->string('port');
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->enum('type', ['http', 'https', 'socks4', 'socks5'])->default('http');
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
        Schema::dropIfExists('proxys');
    }
};

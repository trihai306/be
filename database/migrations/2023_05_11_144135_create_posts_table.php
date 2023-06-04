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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->float('price')->default(0);
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->text('note')->nullable();
            $table->bigInteger('quantity')->default(0);
            $table->text('material');
            $table->enum('size', ['S', 'M', 'L', 'XL', 'XXL'])->nullable();
            $table->enum('status', ['pending', 'success', 'cancel'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};


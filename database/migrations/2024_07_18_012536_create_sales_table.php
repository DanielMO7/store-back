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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('CustomerID');
            $table->unsignedBigInteger('ProductID');
            $table->integer('Amount');
            $table->decimal('ProductValue', 10, 2);
            $table->decimal('Discount', 10, 2);
            $table->decimal('TotalSale', 10, 2);
            $table->foreign('CustomerID')->references('id')->on('customers');
            $table->foreign('ProductID')->references('id')->on('products');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};

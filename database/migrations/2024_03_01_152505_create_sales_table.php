<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

    //criando a tabela de vendas com produtos
    public function up(): void
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->uuid('id')->primary(); //utilizando UUID para evitar que a chave primária seja sequencial e previsível.
            $table->enum('status', ['canceled', 'completed'])->default('completed');
            $table->timestamps();
        });

    //criando tabela pivot para relacionamento entre vendas e produtos
        Schema::create('product_sales', function (Blueprint $table) {
            $table->id();
            $table->uuid('sale_id');
            $table->uuid('product_id');
            $table->integer('amount');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
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


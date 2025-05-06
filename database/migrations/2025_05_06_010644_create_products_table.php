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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onDelete('cascade');
            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')
                ->references('id')
                ->on('suppliers')
                ->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('codigo_barra')->unique();
            $table->decimal('precio_venta', 10, 2); // Precio de venta con 10 dígitos en total y 2 decimales. Un valor válido podría ser 12345678.90 (8 dígitos antes del punto y 2 después).
            $table->decimal('precio_compra', 10, 2); // Precio de compra con 10 dígitos en total y 2 decimales
            $table->integer('stock');
            $table->integer('stock_minimo');
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

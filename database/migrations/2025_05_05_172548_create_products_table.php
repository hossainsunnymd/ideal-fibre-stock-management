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
            $table->string('name');
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('id')->on('categories')
            ->restrictOnDelete()->cascadeOnUpdate();
            $table->decimal('unit',15,2);
            $table->decimal('minimum_stock',15,2)->nullable();
            $table->string('unit_type')->nullable();
            $table->string('parts_no')->nullable();
            $table->string('rack_no')->nullable();
            $table->string('column_no')->nullable();
            $table->string('row_no')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
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

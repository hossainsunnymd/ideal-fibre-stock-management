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
        Schema::create('requisition_received_requests', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('requisitionProduct_id');
            $table->foreign('requisitionProduct_id')->references('id')->on('requisition_products')
            ->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('qty_by_pc');
            $table->decimal('qty_by_kg',15,2);
            $table->decimal('qty_by_feet',15,2);
            $table->decimal('qty_by_coel',15,2);
            $table->string('status')->default('pending');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisition_received_requests');
    }
};

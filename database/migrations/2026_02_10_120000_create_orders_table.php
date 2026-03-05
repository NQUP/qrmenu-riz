<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('name', 120);
            $table->string('phone', 30);
            $table->string('address', 255)->nullable();
            $table->string('table_number', 20)->nullable();
            $table->text('items');
            $table->text('notes')->nullable();
            $table->decimal('total', 12, 2)->nullable();
            $table->string('status', 30)->default('baru');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

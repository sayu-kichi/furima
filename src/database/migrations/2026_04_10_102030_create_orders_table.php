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
        Schema::create('orders', function (Blueprint $table) {
            // id: unsignedBigInteger, Primary Key, Auto Increment
            $table->id();

            // user_id: unsignedBigInteger, Foreign Key to users.id
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // item_id: unsignedBigInteger, Foreign Key to items.id
            $table->foreignId('item_id')
                  ->constrained()
                  ->onDelete('cascade');

            // price: Integer
            $table->integer('price');

            // payment_method: string
            $table->string('payment_method');

            // delivery_address: VARCHAR(256)
            $table->string('delivery_address', 256);

            // status: Integer
            $table->integer('status');

            // Created_at & Updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
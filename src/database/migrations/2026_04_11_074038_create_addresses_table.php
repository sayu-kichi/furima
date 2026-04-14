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
        Schema::create('addresses', function (Blueprint $table) {
            // id: unsignedBigInteger (Laravelのid()はデフォルトでこの型です)
            $table->id();
            
            // user_id: unsignedBigInteger
            $table->unsignedBigInteger('user_id');
            
            // postcode: char
            $table->char('post_code', 8); // ハイフン込みを想定して8桁
            
            // address: VARCHAR(512)
            $table->string('address', 512);
            
            // building: VARCHAR(512)
            $table->string('building', 512)->nullable();
            
            $table->timestamps();

            // 必要に応じて外部キー制約を追加（任意）
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
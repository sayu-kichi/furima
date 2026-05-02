<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * マイグレーションの実行
     */
    public function up(): void
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->string('image_url', 256)->nullable();

            $table->string('display_name', 256)->nullable();

            $table->char('post_code', 8);

            $table->string('address', 256);

            $table->string('building', 256)->nullable();

            $table->timestamps();
        });
    }

    /**
     * マイグレーションの取り消し
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // カテゴリ名
            $table->timestamps();
        });
    }

    /**
     * マイグレーションの取り消し
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
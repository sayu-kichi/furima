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
            // ID列
            $table->id();
            
            // 外部キー：usersテーブルのidを参照
            // constrained() により、参照先テーブル名が自動で users と推論されます
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            // プロフィール詳細情報
            $table->string('display_name')->nullable()->comment('表示名');
            $table->text('bio')->nullable()->comment('自己紹介');
            $table->string('image_url')->nullable()->comment('アバター画像URL');
            
            // フォームの内容に合わせたカラムを追加
            $table->string('post_code')->comment('郵便番号');
            $table->string('address')->comment('住所');
            $table->string('building')->nullable()->comment('建物名');

            
            // 作成日時・更新日時 (created_at, updated_at)
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
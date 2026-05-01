<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndBuyerToItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
        {
            Schema::table('items', function (Blueprint $table) {
                $table->boolean('is_sold')->default(false)->after('condition');
                $table->foreignId('buyer_id')->nullable()->constrained('users')->onDelete('set null')->after('is_sold');
                $table->timestamp('sold_at')->nullable()->after('buyer_id');
            });
        }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            //
        });
    }
}

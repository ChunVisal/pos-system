<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Check if foreign key exists and drop it
            try {
                $table->dropForeign(['customer_id']);
            } catch (Exception $e) {
                // Foreign key might not exist, continue
            }

            // Add correct foreign key
            $table->foreign('customer_id')->references('id')->on('customers')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            try {
                $table->dropForeign(['customer_id']);
            } catch (Exception $e) {
            }

            $table->foreign('customer_id')->references('id')->on('users')->nullOnDelete();
        });
    }
};

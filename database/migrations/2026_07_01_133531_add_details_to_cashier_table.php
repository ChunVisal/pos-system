<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->unique();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('shift')->nullable();
            $table->string('pin')->nullable(); 
            $table->date('hire_date')->nullable();
            $table->decimal('salary', 10, 2)->nullable();
            $table->string('avatar')->nullable();
            $table->string('id_card_number')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->integer('total_transactions')->default(0);
            $table->decimal('total_sales', 10, 2)->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['employee_id', 'phone', 'address', 'shift', 'pin', 'hire_date', 'salary', 'avatar', 'id_card_number', 'emergency_contact', 'emergency_phone', 'bank_name', 'bank_account', 'total_transactions', 'total_sales']);
        });
    }
};

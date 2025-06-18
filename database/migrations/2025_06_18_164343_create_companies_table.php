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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('name');                      // اسم الشركة
            $table->string('logo')->nullable();          // رابط الشعار
            $table->string('banner')->nullable();        // رابط البانر
            $table->string('business_type')->nullable(); // مجال العمل
            $table->string('employees')->nullable();     // عدد الموظفين (نص، مثل "1500+")
            $table->string('country')->nullable();       // البلد
            $table->text('bio')->nullable();             // BIO
            $table->string('phone')->nullable();         // رقم الهاتف للـ Take Action
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

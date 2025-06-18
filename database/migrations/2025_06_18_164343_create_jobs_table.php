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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            // علاقة الوظيفة بالشركة
            $table->foreignId('company_id')
                ->constrained()
                ->cascadeOnDelete();
            // حقل اختياري لفئة العمل (work_field_id)
            $table->unsignedBigInteger('job_type_id')->nullable();
            // حقل اختياري للبلد (country_id)
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('title');             // عنوان الوظيفة
            $table->text('description')->nullable(); // وصف الوظيفة
            $table->string('salary');            // راتب/أجر (مثلاً "100$ - 250$")
            $table->string('experience');        // الخبرة المطلوبة (مثلاً "2-5 Years")
            $table->string('job_time')->nullable();      // مدة الإعلان (مثلاً "30 min")
            $table->date('expiration_date')->nullable(); // تاريخ انتهاء الإعلان
            $table->json('skills')->nullable(); // قائمة المهارات بصيغة JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

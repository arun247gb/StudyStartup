<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ss_milestone_category_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_milestone_categories_id'); 
            $table->enum('study_setup_type', ['external', 'internal'])->default('external');
            $table->enum('completion_type', ['manual', 'auto'])->default('manual');
            $table->string('name'); 
            $table->integer('order')->default(0); 
            $table->boolean('is_active')->default(true); 

            $table->timestamps();
            $table->softDeletes();
            
            $table->foreign('ss_milestone_categories_id')->references('id')->on('ss_milestone_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ss_milestone_category_tasks');
    }
};

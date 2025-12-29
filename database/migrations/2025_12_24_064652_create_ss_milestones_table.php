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
        Schema::create('ss_milestones', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            $table->enum('enum_type', ['option1', 'option2', 'option3'])->nullable(); 
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ss_milestones');
    }
};
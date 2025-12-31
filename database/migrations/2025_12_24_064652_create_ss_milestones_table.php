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
            $table->unsignedBigInteger('milestone_owner_id')->nullable();
            $table->string('name'); 
            $table->integer('order');
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('milestone_owner_id')->references('id')->on('ss_users');
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
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyMilestoneCategoryTasksTable extends Migration
{
    public function up()
    {
        Schema::create('ss_study_milestone_category_tasks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_study_id');
            $table->unsignedBigInteger('ss_organisation_id')->nullable();;

            $table->enum('study_setup_type', ['external', 'internal']);
            $table->enum('completion_type', ['MANUAL', 'AUTO'])->nullable();

            $table->unsignedBigInteger('ss_study_milestone_category_id');
            $table->unsignedBigInteger('ss_milestone_category_tasks_id')->nullable();

            $table->string('name');
            $table->text('description')->nullable();

            $table->tinyInteger('enum_status')->nullable();
            $table->boolean('required')->default(true);

            $table->date('planned_start_date')->nullable();
            $table->date('planned_due_date')->nullable();
            $table->date('actual_start_date')->nullable();
            $table->date('actual_completion_date')->nullable();

            $table->integer('order')->default(0);

            $table->unsignedBigInteger('assigned_to')->nullable()
            $table->unsignedBigInteger('updated_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys with short names
            $table->foreign('ss_study_id', 'fk_study')
                  ->references('id')->on('ss_studies');

            $table->foreign('ss_organisation_id', 'fk_org')
                  ->references('id')->on('ss_organizations');

            $table->foreign('updated_by', 'fk_updated_by')
                  ->references('id')->on('ss_users');

            $table->foreign('assigned_to', 'fk_assigned_to')
                  ->references('id')->on('ss_users');

            $table->foreign('ss_study_milestone_category_id', 'fk_study_category')
                  ->references('id')->on('ss_study_milestone_categories')
                  ->onDelete('cascade');

            $table->foreign('ss_milestone_category_tasks_id', 'fk_category_tasks')
                  ->references('id')->on('ss_milestone_category_tasks')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ss_study_milestone_category_tasks');
    }
}

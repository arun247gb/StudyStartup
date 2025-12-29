<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyTaskSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_study_task_submissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_organisation_id');
            $table->unsignedBigInteger('ss_study_milestone_category_tasks_id');

            $table->string('field_key', 100)->nullable();
            $table->string('value', 100)->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organisation_id')
                ->references('id')
                ->on('ss_organizations')
                ->onDelete('cascade');

            $table->foreign('ss_study_milestone_category_tasks_id', 'fk_submission_task')
                ->references('id')
                ->on('ss_study_milestone_category_tasks')
                ->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_study_task_submissions');
    }
}

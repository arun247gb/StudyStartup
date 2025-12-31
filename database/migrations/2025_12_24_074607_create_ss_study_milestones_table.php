<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyMilestonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_study_milestones', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_organisation_id');
            $table->unsignedBigInteger('ss_site_id')->nullable();
            $table->unsignedBigInteger('ss_study_id');
            $table->unsignedBigInteger('ss_milestone_owner_id')->nullable();
            $table->unsignedBigInteger('ss_milestone_id');

            $table->string('name'); 

            $table->tinyInteger('enum_status');

            $table->integer('order')->nullable();

            $table->date('start_date')->nullable();
            $table->date('planned_due_date')->nullable();
            $table->date('actual_completion_date')->nullable();

            $table->decimal('percent_complete', 5, 2)->default(0);
                        
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organisation_id')->references('id')->on('ss_organizations');
            $table->foreign('ss_site_id')->references('id')->on('ss_sites');
            $table->foreign('ss_study_id')->references('id')->on('ss_studies');
            $table->foreign('ss_milestone_owner_id')->references('id')->on('ss_users');
            $table->foreign('ss_milestone_id')->references('id')->on('ss_milestones');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_study_milestones');
    }
}

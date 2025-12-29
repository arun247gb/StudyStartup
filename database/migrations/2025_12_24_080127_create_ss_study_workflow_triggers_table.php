<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudyWorkflowTriggersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_study_workflow_triggers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_organisation_id');
            $table->unsignedBigInteger('ss_study_id');
            $table->unsignedBigInteger('ss_workflow_trigger_template_id')->nullable();
            $table->string('entity_type', 50)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('trigger_status', 50)->nullable();
            $table->string('action_type', 50)->nullable();
            $table->json('payload_json')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organisation_id')
                  ->references('id')
                  ->on('ss_organizations')
                  ->onDelete('cascade');

            $table->foreign('ss_study_id')
                  ->references('id')
                  ->on('ss_studies')
                  ->onDelete('cascade');

            $table->foreign('ss_workflow_trigger_template_id', 'fk_study_workflow')
                  ->references('id')
                  ->on('ss_workflow_trigger_templates')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_study_workflow_triggers');
    }
}

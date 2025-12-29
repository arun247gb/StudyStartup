<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsWorkflowTriggerTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_workflow_trigger_templates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_milestone_category_tasks_id')->nullable();
            $table->string('entity_type', 50)->nullable();
            $table->unsignedBigInteger('entity_id')->nullable();
            $table->string('trigger_status', 50)->default('COMPLETE');
            $table->string('action_type', 50)->nullable();
            $table->json('payload_json')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('ss_milestone_category_tasks_id', 'fk_workflow_task')
                  ->references('id')
                  ->on('ss_milestone_category_tasks')
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
        Schema::dropIfExists('ss_workflow_trigger_templates');
    }
}

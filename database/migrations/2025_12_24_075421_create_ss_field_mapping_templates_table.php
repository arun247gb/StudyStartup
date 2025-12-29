<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsFieldMappingTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_field_mapping_templates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_milestone_category_tasks_id');

            $table->string('field_key')->nullable();
            $table->string('target_table', 100)->nullable();
            $table->string('target_column', 100)->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key
            $table->foreign('ss_milestone_category_tasks_id', 'fk_milestone_task')
                  ->references('id')
                  ->on('ss_milestone_category_tasks')
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
        Schema::dropIfExists('ss_field_mapping_templates');
    }
}

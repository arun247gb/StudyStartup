<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsFormTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_form_templates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_milestone_category_tasks_id');

            $table->json('form_json'); 

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('ss_milestone_category_tasks_id')
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
        Schema::dropIfExists('ss_form_templates');
    }
}

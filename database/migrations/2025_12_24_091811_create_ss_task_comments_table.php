<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsTaskCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_task_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_organisation_id');
            $table->unsignedBigInteger('ss_user_id')->nullable();
            $table->unsignedBigInteger('ss_study_milestone_tasks_id');

            $table->text('comment_text');

            $table->timestamps();
            $table->softDeletes();
            
            // Foreign keys
            $table->foreign('ss_organisation_id')
                  ->references('id')
                  ->on('ss_organizations')
                  ->onDelete('cascade');

            $table->foreign('ss_user_id')
                  ->references('id')
                  ->on('ss_users')
                  ->onDelete('set null');

            $table->foreign('ss_study_milestone_tasks_id', 'fk_task_comment')
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
        Schema::dropIfExists('ss_task_comments');
    }
}

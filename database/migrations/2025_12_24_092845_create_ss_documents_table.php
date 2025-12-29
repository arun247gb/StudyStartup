<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_documents', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('ss_organizations_id');
            $table->string('sourceable_type', 255);
            $table->unsignedBigInteger('sourceable_id');
            $table->string('document_type', 50);
            $table->string('original_name', 255);
            $table->string('document_path', 255);
            $table->text('notes');
            $table->boolean('monitor_view');

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organizations_id')
                  ->references('id')
                  ->on('ss_organizations')
                  ->onDelete('cascade');

            $table->foreign('created_by')
                  ->references('id')
                  ->on('ss_users')
                  ->onDelete('set null');

            $table->foreign('updated_by')
                  ->references('id')
                  ->on('ss_users')
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
        Schema::dropIfExists('ss_documents');
    }
}

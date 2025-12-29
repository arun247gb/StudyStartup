<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsStudiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_studies', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_organizations_id')->nullable();
            $table->unsignedBigInteger('ss_site_id');

            $table->string('name', 255);
            $table->string('protocol_number', 100);

            $table->unsignedBigInteger('phase_id')->nullable();
            $table->unsignedBigInteger('sponsor_id')->nullable();
            $table->unsignedBigInteger('therapeutic_area_id')->nullable();

            $table->text('description')->nullable();
            $table->unsignedBigInteger('protocol_document_id')->nullable();

            $table->dateTime('planned_activation_date')->nullable();
            $table->boolean('does_ctms_connected');

            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organizations_id')->references('id')->on('ss_organizations')->onDelete('set null');
            $table->foreign('ss_site_id')->references('id')->on('ss_sites')->onDelete('cascade');
            // $table->foreign('phase_id')->references('id')->on('phases')->onDelete('set null');
            // $table->foreign('sponsor_id')->references('id')->on('sponsors')->onDelete('set null');
            // $table->foreign('therapeutic_area_id')->references('id')->on('therapeutic_areas')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('ss_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_studies');
    }
}

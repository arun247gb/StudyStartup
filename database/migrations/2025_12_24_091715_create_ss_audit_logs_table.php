<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsAuditLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_audit_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ss_organisation_id')->nullable();

            $table->string('subject_type', 255);
            $table->unsignedBigInteger('subject_id');

            $table->string('causer_type', 255);
            $table->unsignedBigInteger('causer_id');

            $table->tinyInteger('section');
            $table->string('action', 255);

            $table->string('description', 255)->nullable();
            $table->longText('details')->nullable();
            $table->string('ip_address', 255)->nullable();
            $table->longText('properties')->nullable();

            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            
            $table->timestamps();
            $table->softDeletes();

            // Optional: Foreign keys
            $table->foreign('ss_organisation_id')->references('id')->on('ss_organizations')->onDelete('set null');
            $table->foreign('created_by')->references('id')->on('ss_users')->onDelete('set null');
            $table->foreign('updated_by')->references('id')->on('ss_users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_audit_logs');
    }
}

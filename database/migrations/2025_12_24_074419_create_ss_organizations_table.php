<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsOrganizationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_organizations', function (Blueprint $table) {
            $table->id();
             $table->string('name', 255)->nullable();

            $table->enum('type', ['sponsor', 'cro', 'site', 'ctms_client'])->nullable();
            $table->enum('account_type', ['direct', 'ctms_connected'])->nullable();

            $table->string('external_ctms_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_organizations');
    }
}

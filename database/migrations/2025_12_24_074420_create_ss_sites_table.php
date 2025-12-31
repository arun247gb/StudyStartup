<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsSitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_sites', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_organizations_id')->nullable();
            $table->unsignedBigInteger('ctms_site_id')->nullable();

            $table->string('name', 255)->nullable();
            $table->string('site_number', 255)->nullable();
            $table->string('address_line1', 255)->nullable();
            $table->string('address_line2', 255)->nullable();
            $table->string('city', 255)->nullable();
            $table->char('state', 2)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->char('country', 2)->nullable();
            $table->string('irb_name')->nullable();

            $table->boolean('is_active')->default(true);
            $table->dateTime('activation_date')->nullable();
            $table->unsignedBigInteger('activation_letter_document_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
            
            // Foreign key
            $table->foreign('ss_organizations_id')->references('id')->on('ss_organizations')->onDelete('set null');
            $table->foreign('ctms_site_id')->references('id')->on('ss_sites');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ss_sites');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_departments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_organizations_id');
            $table->string('name', 255)->nullable();
            $table->string('description', 255)->nullable();
            $table->boolean('is_active')->default(true);

            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('ss_organizations_id')
                  ->references('id')
                  ->on('ss_organizations')
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
        Schema::dropIfExists('ss_departments');
    }
}

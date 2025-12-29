<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_users', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_organization_id')->nullable();
            $table->unsignedBigInteger('ss_department_id')->nullable();

            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->string('password', 255)->nullable();

            $table->enum('auth_source', ['local', 'sso'])->default('local');

            $table->timestamps();
            $table->softDeletes();

            // Foreign keys
            $table->foreign('ss_organization_id')
                  ->references('id')
                  ->on('ss_organizations')
                  ->onDelete('set null');

            $table->foreign('ss_department_id')
                  ->references('id')
                  ->on('ss_departments')
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
        Schema::dropIfExists('ss_users');
    }
}

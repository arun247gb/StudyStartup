<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSsUserAuthAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ss_user_auth_accounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('ss_user_id')->nullable();
            $table->unsignedBigInteger('ctms_user_id');
            $table->string('email', 255);

            $table->timestamps();
            $table->softDeletes();

            // Foreign key
            $table->foreign('ss_user_id')
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
        Schema::dropIfExists('ss_user_auth_accounts');
    }
}

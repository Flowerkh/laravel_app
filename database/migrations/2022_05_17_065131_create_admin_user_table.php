<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_user', function (Blueprint $table) {
            $table->integer('u_idx',true);
            $table->string('email',100);
            $table->string('password',255);
            $table->string('u_name',20);
            $table->string('team',255);
            $table->timestamp('c_date')->useCurrent();
            $table->string('u_date',20)->nullable(true);
            $table->tinyInteger('use_yn');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_user');
    }
}

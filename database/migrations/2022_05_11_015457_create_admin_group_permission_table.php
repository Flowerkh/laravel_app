<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminGroupPermissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_group_permission', function (Blueprint $table) {
            $table->integer('p_idx',11);
            $table->integer('g_idx',false,11);
            $table->integer('s_idx',false,11);
            $table->set('admin_auth',['r','w','x']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_group_permission');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupAuthMappingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_auth_mapping', function (Blueprint $table) {
            $table->integer('ga_idx',true);
            $table->integer('g_idx');
            $table->integer('s_idx');
            $table->integer('a_idx');
            $table->integer('auth');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('group_auth_mapping');
    }
}

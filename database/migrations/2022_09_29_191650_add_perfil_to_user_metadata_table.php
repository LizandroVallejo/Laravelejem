<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_metadata', function (Blueprint $table) {
             $table->unsignedBigInteger('perfil_id')->default(1);
            $table->foreign('perfil_id')->references('id')->on('perfil')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_metadata', function (Blueprint $table) {
            $table->dropForeign('lists_perfil_id_foreign');
            $table->dropIndex('lists_perfil_id_index');
            $table->dropColumn('perfil_id');
        });
    }
};

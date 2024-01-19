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
    Schema::table('matieres', function (Blueprint $table) {
        $table->unsignedBigInteger('classe_id')->after('id');
        $table->foreign('classe_id')->references('id')->on('classes')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('matieres', function (Blueprint $table) {
            //
        });
    }
};

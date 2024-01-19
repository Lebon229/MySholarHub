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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classe_id')->constrained();
            $table->foreignId('id_eleve')->constrained();
            $table->foreignId('id_matiere')->constrained();
            $table->decimal('note', 5, 2);
            $table->decimal('interro_1', 5, 2)->nullable();
            $table->decimal('interro_2', 5, 2)->nullable();
            $table->decimal('interro_3', 5, 2)->nullable();
            $table->decimal('interro_4', 5, 2)->nullable();
            $table->decimal('devoir_1', 5, 2)->nullable();
            $table->decimal('devoir_2', 5, 2)->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
};

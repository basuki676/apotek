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
    public function up(): void
    {
        Schema::create('medicines', function (Blueprint $table) {
            $table->id(); //primary key
            $table->enum('type',['tablet','sirup','kapsul']);
            $table->string('name');
            $table->integer('price');
            $table->integer('stock');
            $table->timestamps(); //akan menghasilkan dua colum : created_at (auto terisi tgl pembuatan data), update_at (auto terisi tgl data diubah)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('medicines');
    }
};

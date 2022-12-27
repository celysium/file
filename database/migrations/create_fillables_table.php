<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fillables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('file_id')
                ->constrained('files')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
            $table->integer('fillable_id');
            $table->string('fillable_type');
            $table->string('type')->nullable();
            $table->json('data')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fillables');
    }
};

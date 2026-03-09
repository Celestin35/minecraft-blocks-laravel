<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('blocks', function (Blueprint $table) {
    $table->id();
    $table->string('file_name');
    $table->string('block_name');
    $table->string('variant')->nullable();
    $table->string('avg_color_srgb')->nullable();
    $table->string('avg_color_linear')->nullable();
    $table->string('category')->nullable();
    $table->string('family')->nullable();
    $table->string('material')->nullable();
    $table->boolean('is_transparent')->default(false);
    $table->boolean('is_solid')->default(true);
    $table->string('detail_form')->nullable();
    $table->boolean('detail_flammable')->default(false);
    $table->boolean('detail_interactive')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blocks');
    }
};

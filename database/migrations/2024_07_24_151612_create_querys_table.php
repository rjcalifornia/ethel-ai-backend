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
        Schema::create('querys', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('app_id');
            $table->text('prompt');
            $table->text('model_response');
            $table->decimal('prompt_token_count', 14, 4);
            $table->decimal('response_token_count', 14, 4);
            $table->decimal('total_tokens_used', 14, 4);
            $table->string('model_name');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('querys');
    }
};

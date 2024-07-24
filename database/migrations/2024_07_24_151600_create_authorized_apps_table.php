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
        Schema::create('authorized_apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('client_id');
            $table->string('api_key');
            $table->unsignedInteger('role_id');
            $table->boolean('active');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('authorized_apps');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t032_api_tokens', function (Blueprint $table) {
            $table->id('id_token');
            $table->unsignedBigInteger('id_user');
            $table->string('token', 64)->unique();
            $table->dateTime('expires_at');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('t032_users')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t032_api_tokens');
    }
};

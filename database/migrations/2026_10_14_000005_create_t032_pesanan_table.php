<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('t032_pesanan', function (Blueprint $table) {
            $table->id('id_pesanan');
            $table->unsignedBigInteger('id_user');
            $table->string('nomor_pesanan', 50)->unique();
            $table->decimal('total_harga', 12, 2)->default(0.00);
            $table->enum('status', ['Menunggu Pembayaran', 'Diproses', 'Selesai', 'Dibatalkan'])->default('Menunggu Pembayaran');
            $table->timestamps();

            $table->foreign('id_user')
                  ->references('id_user')
                  ->on('t032_users')
                  ->onUpdate('cascade')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('t032_pesanan');
    }
};

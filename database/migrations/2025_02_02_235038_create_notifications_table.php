<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Pengguna yang menerima notifikasi
            $table->foreignId('task_id')->constrained()->onDelete('cascade'); // Tugas yang terkait
            $table->string('message'); // Pesan notifikasi
            $table->boolean('is_read')->default(false); // Status notifikasi (sudah dibaca/belum)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}

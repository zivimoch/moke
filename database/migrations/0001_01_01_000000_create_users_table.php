<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('name');
            $table->char('kotkab_id')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->char('no_telp')->unique()->nullable();
            $table->string('wilayah')->nullable();
            $table->enum('jabatan', ['Super Admin', 'Penerima Pengaduan', 'Manajer Kasus', 'Pendamping Kasus', 'Psikolog', 'Konselor', 'Advokat', 'Paralegal', 'Unit Reaksi Cepat', 'Supervisor Kasus', 'Tenaga Ahli', 'Sekretariat', 'Kepala Instansi', 'Tim Data']);
            // $table->integer('supervisor_layanan')->default(0)->comment('jika 1 maka dia akan dapat notifikasi jika ada update kasus dari user yang supervisor_idnya adalah dia');
            $table->integer('supervisor_id')->default(0)->comment('siapa supervisornya, jika 0 maka dia bisa melihat seluruh kasus karna dia tidak dibawah siapa2 jadi dia bisa melihat seluruh kasus. Misal paralegal input laporan, karna dia spv_id nya adalah advokat maka advokat dapet notif. Dan advokat ketika komentar maka TA dapet notif karna spv_id nya adv adalah TA');
            $table->string('password');
            $table->string('foto')->nullable();
            $table->string('tandatangan')->nullable();
            $table->integer('settings_tabel_intervensi')->default(2);
            $table->string('settings_navbar_bg_color')->default('default');
            $table->string('settings_kontainer_width')->default('normal');
            $table->boolean('active')->default(1);
            $table->rememberToken();
            $table->timestamps();
            $table->dateTime('deleted_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('sessions');
    }
};

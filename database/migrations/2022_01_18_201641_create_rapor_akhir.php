<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporAkhir extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_akhirs', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->unsignedBigInteger('siswa_id');
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
            $table->date('ra_tanggal');
            $table->string('ra_walikelas', 100);
            $table->integer('ra_spiritual_nilai')->nullable();
            $table->char('ra_spiritual_predikat', 1)->nullable();
            $table->text('ra_spiritual_deskripsi')->nullable();
            $table->integer('ra_sosial_nilai')->nullable();
            $table->char('ra_sosial_predikat', 1)->nullable();
            $table->text('ra_sosial_deskripsi')->nullable();
            $table->integer('ra_pak_pengetahuan_nilai')->nullable();
            $table->char('ra_pak_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_pak_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_pak_keterampilan_nilai')->nullable();
            $table->char('ra_pak_keterampilan_predikat', 1)->nullable();
            $table->text('ra_pak_keterampilan_deskripsi')->nullable();
            $table->integer('ra_pkn_pengetahuan_nilai')->nullable();
            $table->char('ra_pkn_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_pkn_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_pkn_keterampilan_nilai')->nullable();
            $table->char('ra_pkn_keterampilan_predikat', 1)->nullable();
            $table->text('ra_pkn_keterampilan_deskripsi')->nullable();
            $table->integer('ra_bin_pengetahuan_nilai')->nullable();
            $table->char('ra_bin_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_bin_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_bin_keterampilan_nilai')->nullable();
            $table->char('ra_bin_keterampilan_predikat', 1)->nullable();
            $table->text('ra_bin_keterampilan_deskripsi')->nullable();
            $table->integer('ra_mat_pengetahuan_nilai')->nullable();
            $table->char('ra_mat_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_mat_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_mat_keterampilan_nilai')->nullable();
            $table->char('ra_mat_keterampilan_predikat', 1)->nullable();
            $table->text('ra_mat_keterampilan_deskripsi')->nullable();
            $table->integer('ra_ipa_pengetahuan_nilai')->nullable();
            $table->char('ra_ipa_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_ipa_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_ipa_keterampilan_nilai')->nullable();
            $table->char('ra_ipa_keterampilan_predikat', 1)->nullable();
            $table->text('ra_ipa_keterampilan_deskripsi')->nullable();
            $table->integer('ra_ips_pengetahuan_nilai')->nullable();
            $table->char('ra_ips_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_ips_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_ips_keterampilan_nilai')->nullable();
            $table->char('ra_ips_keterampilan_predikat', 1)->nullable();
            $table->text('ra_ips_keterampilan_deskripsi')->nullable();
            $table->integer('ra_big_pengetahuan_nilai')->nullable();
            $table->char('ra_big_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_big_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_big_keterampilan_nilai')->nullable();
            $table->char('ra_big_keterampilan_predikat', 1)->nullable();
            $table->text('ra_big_keterampilan_deskripsi')->nullable();
            $table->integer('ra_bdy_pengetahuan_nilai')->nullable();
            $table->char('ra_bdy_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_bdy_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_bdy_keterampilan_nilai')->nullable();
            $table->char('ra_bdy_keterampilan_predikat', 1)->nullable();
            $table->text('ra_bdy_keterampilan_deskripsi')->nullable();
            $table->integer('ra_org_pengetahuan_nilai')->nullable();
            $table->char('ra_org_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_org_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_org_keterampilan_nilai')->nullable();
            $table->char('ra_org_keterampilan_predikat', 1)->nullable();
            $table->text('ra_org_keterampilan_deskripsi')->nullable();
            $table->integer('ra_pky_pengetahuan_nilai')->nullable();
            $table->char('ra_pky_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_pky_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_pky_keterampilan_nilai')->nullable();
            $table->char('ra_pky_keterampilan_predikat', 1)->nullable();
            $table->text('ra_pky_keterampilan_deskripsi')->nullable();
            $table->integer('ra_jwa_pengetahuan_nilai')->nullable();
            $table->char('ra_jwa_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_jwa_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_jwa_keterampilan_nilai')->nullable();
            $table->char('ra_jwa_keterampilan_predikat', 1)->nullable();
            $table->text('ra_jwa_keterampilan_deskripsi')->nullable();
            $table->integer('ra_man_pengetahuan_nilai')->nullable();
            $table->char('ra_man_pengetahuan_predikat', 1)->nullable();
            $table->text('ra_man_pengetahuan_deskripsi')->nullable();
            $table->integer('ra_man_keterampilan_nilai')->nullable();
            $table->char('ra_man_keterampilan_predikat', 1)->nullable();
            $table->text('ra_man_keterampilan_deskripsi')->nullable();
            $table->text('ra_ekstra1_kegiatan')->nullable();
            $table->char('ra_ekstra1_nilai', 1)->nullable();
            $table->char('ra_ekstra1_predikat', 15)->nullable();
            $table->text('ra_ekstra2_kegiatan')->nullable();
            $table->char('ra_ekstra2_nilai', 1)->nullable();
            $table->char('ra_ekstra2_predikat', 15)->nullable();
            $table->text('ra_ekstra3_kegiatan')->nullable();
            $table->char('ra_ekstra3_nilai', 1)->nullable();
            $table->char('ra_ekstra3_predikat', 15)->nullable();
            $table->integer('ra_catatan_sakit')->nullable();
            $table->integer('ra_catatan_ijin')->nullable();
            $table->integer('ra_catatan_alpha')->nullable();
            $table->text('ra_catatan_ayat')->nullable();
            $table->text('ra_catatan_isi')->nullable();
            $table->text('ra_catatan_pesan')->nullable();
            $table->timestamps();

            $table->foreign('siswa_id')->references('id')->on('siswas');
            $table->foreign('periode_id')->references('id')->on('periodes');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rapor_akhirs');
    }
}

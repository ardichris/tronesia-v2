<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporSisipansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rapor_sisipans', function (Blueprint $table) {
            $table->string('id', 36)->primary();
            $table->unsignedBigInteger('siswa_id');
            $table->date('rs_tanggal')->nullable();
            $table->integer('rs_spiritual_nilai')->nullable();
            $table->integer('rs_spiritual_predikat')->nullable();
            $table->integer('rs_spiritual_deskripsi')->nullable();
            $table->integer('rs_sosial_nilai')->nullable();
            $table->integer('rs_sosial_predikat')->nullable();
            $table->integer('rs_sosial_deskripsi')->nullable();
            $table->integer('rs_pak_uh1')->nullable();
            $table->integer('rs_pak_uh2')->nullable();
            $table->integer('rs_pak_uh3')->nullable();
            $table->integer('rs_pak_tgs1')->nullable();
            $table->integer('rs_pak_tgs2')->nullable();
            $table->integer('rs_pak_tgs3')->nullable();
            $table->integer('rs_pak_pts')->nullable();
            $table->integer('rs_pak_prk')->nullable();
            $table->integer('rs_pak_pry')->nullable();
            $table->integer('rs_pak_prd')->nullable();
            $table->integer('rs_pkn_uh1')->nullable();
            $table->integer('rs_pkn_uh2')->nullable();
            $table->integer('rs_pkn_uh3')->nullable();
            $table->integer('rs_pkn_tgs1')->nullable();
            $table->integer('rs_pkn_tgs2')->nullable();
            $table->integer('rs_pkn_tgs3')->nullable();
            $table->integer('rs_pkn_pts')->nullable();
            $table->integer('rs_pkn_prk')->nullable();
            $table->integer('rs_pkn_pry')->nullable();
            $table->integer('rs_pkn_prd')->nullable();
            $table->integer('rs_bin_uh1')->nullable();
            $table->integer('rs_bin_uh2')->nullable();
            $table->integer('rs_bin_uh3')->nullable();
            $table->integer('rs_bin_tgs1')->nullable();
            $table->integer('rs_bin_tgs2')->nullable();
            $table->integer('rs_bin_tgs3')->nullable();
            $table->integer('rs_bin_pts')->nullable();
            $table->integer('rs_bin_prk')->nullable();
            $table->integer('rs_bin_pry')->nullable();
            $table->integer('rs_bin_prd')->nullable();
            $table->integer('rs_big_uh1')->nullable();
            $table->integer('rs_big_uh2')->nullable();
            $table->integer('rs_big_uh3')->nullable();
            $table->integer('rs_big_tgs1')->nullable();
            $table->integer('rs_big_tgs2')->nullable();
            $table->integer('rs_big_tgs3')->nullable();
            $table->integer('rs_big_pts')->nullable();
            $table->integer('rs_big_prk')->nullable();
            $table->integer('rs_big_pry')->nullable();
            $table->integer('rs_big_prd')->nullable();
            $table->integer('rs_mat_uh1')->nullable();
            $table->integer('rs_mat_uh2')->nullable();
            $table->integer('rs_mat_uh3')->nullable();
            $table->integer('rs_mat_tgs1')->nullable();
            $table->integer('rs_mat_tgs2')->nullable();
            $table->integer('rs_mat_tgs3')->nullable();
            $table->integer('rs_mat_pts')->nullable();
            $table->integer('rs_mat_prk')->nullable();
            $table->integer('rs_mat_pry')->nullable();
            $table->integer('rs_mat_prd')->nullable();
            $table->integer('rs_bio_uh1')->nullable();
            $table->integer('rs_bio_uh2')->nullable();
            $table->integer('rs_bio_uh3')->nullable();
            $table->integer('rs_bio_tgs1')->nullable();
            $table->integer('rs_bio_tgs2')->nullable();
            $table->integer('rs_bio_tgs3')->nullable();
            $table->integer('rs_bio_pts')->nullable();
            $table->integer('rs_bio_prk')->nullable();
            $table->integer('rs_bio_pry')->nullable();
            $table->integer('rs_bio_prd')->nullable();
            $table->integer('rs_fis_uh1')->nullable();
            $table->integer('rs_fis_uh2')->nullable();
            $table->integer('rs_fis_uh3')->nullable();
            $table->integer('rs_fis_tgs1')->nullable();
            $table->integer('rs_fis_tgs2')->nullable();
            $table->integer('rs_fis_tgs3')->nullable();
            $table->integer('rs_fis_pts')->nullable();
            $table->integer('rs_fis_prk')->nullable();
            $table->integer('rs_fis_pry')->nullable();
            $table->integer('rs_fis_prd')->nullable();
            $table->integer('rs_eko_uh1')->nullable();
            $table->integer('rs_eko_uh2')->nullable();
            $table->integer('rs_eko_uh3')->nullable();
            $table->integer('rs_eko_tgs1')->nullable();
            $table->integer('rs_eko_tgs2')->nullable();
            $table->integer('rs_eko_tgs3')->nullable();
            $table->integer('rs_eko_pts')->nullable();
            $table->integer('rs_eko_prk')->nullable();
            $table->integer('rs_eko_pry')->nullable();
            $table->integer('rs_eko_prd')->nullable();
            $table->integer('rs_geo_uh1')->nullable();
            $table->integer('rs_geo_uh2')->nullable();
            $table->integer('rs_geo_uh3')->nullable();
            $table->integer('rs_geo_tgs1')->nullable();
            $table->integer('rs_geo_tgs2')->nullable();
            $table->integer('rs_geo_tgs3')->nullable();
            $table->integer('rs_geo_pts')->nullable();
            $table->integer('rs_geo_prk')->nullable();
            $table->integer('rs_geo_pry')->nullable();
            $table->integer('rs_geo_prd')->nullable();
            $table->integer('rs_sej_uh1')->nullable();
            $table->integer('rs_sej_uh2')->nullable();
            $table->integer('rs_sej_uh3')->nullable();
            $table->integer('rs_sej_tgs1')->nullable();
            $table->integer('rs_sej_tgs2')->nullable();
            $table->integer('rs_sej_tgs3')->nullable();
            $table->integer('rs_sej_pts')->nullable();
            $table->integer('rs_sej_prk')->nullable();
            $table->integer('rs_sej_pry')->nullable();
            $table->integer('rs_sej_prd')->nullable();
            $table->integer('rs_snr_uh1')->nullable();
            $table->integer('rs_snr_uh2')->nullable();
            $table->integer('rs_snr_uh3')->nullable();
            $table->integer('rs_snr_tgs1')->nullable();
            $table->integer('rs_snr_tgs2')->nullable();
            $table->integer('rs_snr_tgs3')->nullable();
            $table->integer('rs_snr_pts')->nullable();
            $table->integer('rs_snr_prk')->nullable();
            $table->integer('rs_snr_pry')->nullable();
            $table->integer('rs_snr_prd')->nullable();
            $table->integer('rs_snm_uh1')->nullable();
            $table->integer('rs_snm_uh2')->nullable();
            $table->integer('rs_snm_uh3')->nullable();
            $table->integer('rs_snm_tgs1')->nullable();
            $table->integer('rs_snm_tgs2')->nullable();
            $table->integer('rs_snm_tgs3')->nullable();
            $table->integer('rs_snm_pts')->nullable();
            $table->integer('rs_snm_prk')->nullable();
            $table->integer('rs_snm_pry')->nullable();
            $table->integer('rs_snm_prd')->nullable();
            $table->integer('rs_org_uh1')->nullable();
            $table->integer('rs_org_uh2')->nullable();
            $table->integer('rs_org_uh3')->nullable();
            $table->integer('rs_org_tgs1')->nullable();
            $table->integer('rs_org_tgs2')->nullable();
            $table->integer('rs_org_tgs3')->nullable();
            $table->integer('rs_org_pts')->nullable();
            $table->integer('rs_org_prk')->nullable();
            $table->integer('rs_org_pry')->nullable();
            $table->integer('rs_org_prd')->nullable();
            $table->integer('rs_mek_uh1')->nullable();
            $table->integer('rs_mek_uh2')->nullable();
            $table->integer('rs_mek_uh3')->nullable();
            $table->integer('rs_mek_tgs1')->nullable();
            $table->integer('rs_mek_tgs2')->nullable();
            $table->integer('rs_mek_tgs3')->nullable();
            $table->integer('rs_mek_pts')->nullable();
            $table->integer('rs_mek_prk')->nullable();
            $table->integer('rs_mek_pry')->nullable();
            $table->integer('rs_mek_prd')->nullable();
            $table->integer('rs_jwa_uh1')->nullable();
            $table->integer('rs_jwa_uh2')->nullable();
            $table->integer('rs_jwa_uh3')->nullable();
            $table->integer('rs_jwa_tgs1')->nullable();
            $table->integer('rs_jwa_tgs2')->nullable();
            $table->integer('rs_jwa_tgs3')->nullable();
            $table->integer('rs_jwa_pts')->nullable();
            $table->integer('rs_jwa_prk')->nullable();
            $table->integer('rs_jwa_pry')->nullable();
            $table->integer('rs_jwa_prd')->nullable();
            $table->integer('rs_man_uh1')->nullable();
            $table->integer('rs_man_uh2')->nullable();
            $table->integer('rs_man_uh3')->nullable();
            $table->integer('rs_man_tgs1')->nullable();
            $table->integer('rs_man_tgs2')->nullable();
            $table->integer('rs_man_tgs3')->nullable();
            $table->integer('rs_man_pts')->nullable();
            $table->integer('rs_man_prk')->nullable();
            $table->integer('rs_man_pry')->nullable();
            $table->integer('rs_man_prd')->nullable();
            $table->string('rs_catatan_ayat')->nullable();
            $table->string('rs_catatan_isi')->nullable();
            $table->string('rs_catatan')->nullable();
            $table->integer('rs_absensi_sakit')->nullable();
            $table->integer('rs_absensi_ijin')->nullable();
            $table->integer('rs_absensi_alpha')->nullable();
            $table->unsignedBigInteger('periode_id');
            $table->unsignedBigInteger('unit_id');
            $table->unsignedBigInteger('user_id');
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
        Schema::dropIfExists('rapor_sisipans');
    }
}

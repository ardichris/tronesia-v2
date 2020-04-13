<template>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <breadcrumb></breadcrumb>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-user-injured"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Absensi</span>
                <span class="info-box-number">
                  {{statistiks.data.absensitoday.length}} / {{statistiks.data.absensitotal}}
                </span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-exclamation-triangle"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Pelanggaran</span>
                <span class="info-box-number">{{statistiks.data.pelanggarantoday.length}} / {{statistiks.data.pelanggarantotal}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>

          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-success elevation-1"><i class="fas fa-tasks"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Jurnal Mengajar</span>
                <span class="info-box-number">{{statistiks.data.jurnaltoday.total}} / {{statistiks.data.jurnaltotal}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
          <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-house-damage"></i></span>

              <div class="info-box-content">
                <span class="info-box-text">Kerusakan Sarpras</span>
                <span class="info-box-number">{{statistiks.data.jumlahKerusakan}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
      <div class="row">
        <div class="col-md-3">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Siswa Absen Hari Ini</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#absensi">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div id="absensi" class="card-body p-0 collapse">
              <div class="table-responsive">
                <b-table striped hover :items="statistiks.data.absensitoday" :fields="fieldsabsensi" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{row.item.siswa.siswa_nama}} / <b>{{row.item.siswa.siswa_kelas}}</b>
                    </template>
                    <template v-slot:cell(absensi_jenis)="row">
                        <span class="badge badge-danger" v-if="row.item.absensi_jenis == 'Sakit'">Sakit</span>
                        <span class="badge badge-success" v-if="row.item.absensi_jenis == 'Ijin'">Ijin</span>
                        <span class="badge badge-warning" v-if="row.item.absensi_jenis == 'Alpha'">Alpha</span>
                    </template>
                </b-table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Pelanggaran Siswa Hari Ini</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#pelanggaran">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div id="pelanggaran" class="card-body p-0 collapse">
              <div class="table-responsive">
                <b-table striped hover :items="statistiks.data.pelanggarantoday" :fields="fields" show-empty>                	
                    <template v-slot:cell(siswa_id)="row">
                        {{ row.item.siswa_id ? row.item.siswa.siswa_nama:'-' }}
                    </template>
                    <template v-slot:cell(pelanggaran_jenis)="row">
                        <span class="badge badge-danger" v-if="row.item.pelanggaran_jenis == 'Berkelahi'">Berkelahi</span>
                        <span class="badge badge-success" v-else-if="row.item.pelanggaran_jenis == 'Terlambat'">Terlambat</span>
                        <span class="badge badge-warning" v-else>{{row.item.pelanggaran_jenis}}</span>
                    </template>
                </b-table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Jurnal Mengajar Hari Ini</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#jurnal">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header --> 
            <div id="jurnal" class="card-body p-0 collapse">
              <div class="table-responsive ">
                <b-table striped hover :items="statistiks.data.jurnaltoday.data" :fields="fieldsjurnal" show-empty>                	
                    <template v-slot:cell(kelas_id)="row">
                        {{ row.item.kelas_id ? row.item.kelas.kelas_nama:'-' }}
                    </template>
                    <template v-slot:cell(jm_status)="row">
                        <span class="badge badge-success" v-if="row.item.jm_status == 1">Approved</span>
                        <span class="badge badge-danger" v-else-if="row.item.jm_status == 2">Reject</span>
                        <span class="badge badge-warning" v-else-if="row.item.jm_status == 0">Waiting</span>
                    </template>
                </b-table> 
                  <span class="float-right">
                      <b-pagination
                          v-model="page"
                          :total-rows="statistiks.data.jurnaltoday.total"
                          :per-page="statistiks.data.jurnaltoday.per_page"
                          aria-controls="jurnals"
                          v-if="statistiks.data.jurnaltoday && statistiks.data.jurnaltoday.data.length > 0"
                          ></b-pagination>
                  </span>              
              </div>
              
              
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
        <div class="col-md-3">
          <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Daftar Kerusakan Sarpras</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-toggle="collapse" data-target="#kerusakan">
                  <i class="fas fa-plus"></i>
                </button>
              </div>
            </div>
            <!-- /.card-header -->
            <div id="kerusakan" class="card-body p-0 collapse">
              <div class="table-responsive">
                <b-table striped hover :items="statistiks.data.kerusakanDetail" :fields="fieldskerusakan" show-empty>
                    <template v-slot:cell(ls_status)="row">
                        <span class="badge badge-info" v-if="row.item.ls_status == 1">Proses</span>
                        <span class="badge badge-warning" v-else-if="row.item.ls_status == 0">Tunggu</span>
                    </template>
                </b-table>
              </div>
              <!-- /.table-responsive -->
            </div>
            <!-- /.card-body -->
          </div>
            <!-- /.card -->
        </div>
      </div>
    </section>
    <!-- /.content -->
  </div>
    
</template>
<script>
  import Breadcrumb from '../components/Breadcrumb.vue'
  import { mapActions, mapState } from 'vuex'
  export default {
      name: 'Home',
      created() {
        this.getData()
      },
      data() {
        return {
            //FIELD YANG AKAN DITAMPILKAN PADA TABLE DIATAS
            fields: [
                { key: 'siswa_id', label: 'Nama' },
                { key: 'pelanggaran_jenis', label: 'Pelanggaran' },
            ],
            fieldsabsensi: [
                { key: 'siswa_id', label: 'Nama' },
                { key: 'absensi_jenis', label: 'Absensi' },
            ],
            fieldsjurnal: [
                { key: 'kelas_id', label: 'Kelas' },
                { key: 'jm_jampel', label: 'Jam' },
                { key: 'jm_status', label: 'Status' }
            ],
            fieldskerusakan: [
                { key: 'ls_sarpras', label: 'Sarana' },
                { key: 'ls_status', label: 'Status' }
            ],
            search: ''
        }
      },
      computed: {
        ...mapState('home', {
            statistiks: state => state.statistiks
        }),
        page: {
            get() {
                return this.$store.state.home.page
            },
            set(val) {
                this.$store.commit('home/SET_PAGE', val)
            }
        }
      },
      watch: {
        page() {
            this.getData()
        },
      },
      methods: {
        ...mapActions('home', ['getData'])
      },
      components: {
          'breadcrumb': Breadcrumb
      }
  }
</script>
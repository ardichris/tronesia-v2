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
                  {{statistiks.absensitoday}} / {{statistiks.absensitotal}}
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
                <span class="info-box-number">{{statistiks.pelanggarantoday}} / {{statistiks.pelanggarantotal}}</span>
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
                <span class="info-box-number">{{statistiks.jurnaltoday}} / {{statistiks.jurnaltotal}}</span>
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
                <span class="info-box-number">{{statistiks.jumlahKerusakan}}</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="row">
          <div class="col-md-9">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  <i class="fas fa-bullhorn mr-1"></i>
                  Pengumuman
                </h3>
                <!--span class="float-right">
                  <button type="button" class="btn btn-success btn-circle btn-sm"><i class="fa fa-plus"></i></button>
                </span--> 
                <div class="card-tools">
                </div>
              </div><!-- /.card-header -->
              <div class="card-body">
                <!-- The time line -->
                <div class="timeline">
                  <!-- timeline time label -->
                  <div class="time-label">
                    <span class="bg-green">Pengumuman Terakhir</span>
                  </div>
                  <!-- /.timeline-label -->
                  <!-- timeline item -->
                  <div v-for="item in statistiks.pengumuman">
                    <i v-if="item.p_kategori=='Siswa'" class="fas fa-bullhorn bg-green"></i>
                    <i v-if="item.p_kategori=='Guru'" class="fas fa-bell bg-yellow"></i>
                    <i v-if="item.p_kategori=='Penting'" class="fas fa-exclamation bg-red"></i>
                    <div class="timeline-item">
                      <span class="time"><i class="fas fa-clock"></i> {{item.p_tanggal}}</span>
                      <h3 class="timeline-header no-border"><b>{{item.p_title}}</b></h3>
                      <div class="timeline-body" v-html="item.p_isi">
                        {{ item.p_isi }}
                      </div>
                      <div class="timeline-footer">
                        <span class="badge badge-info">{{item.user.name}}</span>
                      </div>
                    </div>
                  </div>
                  <!-- END timeline item -->
                  <div>
                    <i class="fas fa-clock bg-gray"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            
          </div>
      </div>
      </div><!--/. container-fluid -->
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
            fieldtimeline: [
                {key: 'p_tanggal', label: ''},
                {key: 'p_title', label: ''},
                {key: 'p_isi', label: ''},
                {key: 'user_id', label: ''},
            ],
            search: '',
        }
      },
      computed: {
        ...mapState('home', {
            statistiks: state => state.statistiks
        }),
      //   page: {
      //       get() {
      //           return this.$store.state.home.page
      //       },
      //       set(val) {
      //           this.$store.commit('home/SET_PAGE', val)
      //       }
      //   }
       },
      // watch: {
      //   page() {
      //       this.getData()
      //   },
      // },
      methods: {
        ...mapActions('home', ['getData']),
        handleDateClick: function(arg) {
          alert('date click! ' + arg.dateStr)
        }
      },
      components: {
          'breadcrumb': Breadcrumb
      }
  }
</script>
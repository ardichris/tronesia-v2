<template>
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <!--<li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>-->
    </ul>

 
    <!--<form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>-->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <button class="btn btn-danger btn-sm btn-flat" @click.prevent="logout">
            <i class="fas fa-power-off"></i> Sign out
          </button>
        </a>
      </li>
    </ul>
  </nav>
</template>

<script>
export default {
  methods: {
        logout() {
            return new Promise((resolve, reject) => {
                localStorage.removeItem('token') //MENGHAPUS TOKEN DARI LOCALSTORAGE
                resolve()
            }).then(() => {
                //MEMPERBAHARUI STATE TOKEN
                this.$store.state.token = localStorage.getItem('token')
                this.$router.push('/login') //REDIRECT KE PAGE LOGIN
            })
        },
    }
}
</script>
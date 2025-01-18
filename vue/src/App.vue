<script setup>
import { ref, watch, onMounted, nextTick } from 'vue';
import { useRoute } from 'vue-router';

const isHome = ref(false);
const isMenu = ref(false);
const isOrder = ref(false);

const orders = localStorage.getItem('food');

const route = useRoute(); // Get the current route

// Watch for route changes and update state
watch(
  () => route.path, // Watching the path of the current route
  async (newPath) => {
    if (newPath === '/') {
      isHome.value = true;
      isMenu.value = false;
      isOrder.value = false;
    } else if (newPath === '/menu') {
      isMenu.value = true;
      isHome.value = false;
      isOrder.value = false;
    } else if(newPath === '/order'){
      isOrder.value = true;
      isMenu.value = false;
      isHome.value = false;
    }

    await nextTick(); // Wait for DOM updates
    feather.replace(); // Replace icons after DOM updates
  },
  { immediate: true } // Run on initial load
);

onMounted(() => {
  feather.replace();
});
</script>

<template>
  <div>
    <nav v-if="isHome" class="navbar">
      <a href="/" class="navbar-logo">Pillar<span>Tasty</span></a>

      <div class="navbar-nav">
        <a href="/"> Home </a>
        <a href="#about"> tentang kami </a>
        <a href="/menu"> menu </a>
        <a href="#footer"> kontak </a>
      </div>

      <div class="navbar-extra">
        <!-- <a href="" id="search"><i data-feather="search"></i></a> -->
        <a href="/menu" id="shopping-cart"><i data-feather="book-open"></i></a>
      </div>
    </nav>

    <nav v-if="isMenu" class="navbar" style="background-color: #e3e3e3;">
      <a href="/" class="navbar-logo">Pillar<span>Tasty</span></a>

      <div class="navbar-nav">
        <a href="/"> Home </a>
        <a v-if="orders" href="/order"> orders </a>
        <!-- <a href="#about"> tentang kami </a> -->
        <!-- <a href="/menu"> menu </a> -->
        <!-- <a href="#contact"> kontak </a> -->
      </div>

      <div class="navbar-extra">
        <a href="/menu" id="search"><i data-feather="book-open"></i></a>
        <a href="/order" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
      </div>
    </nav>

    <nav v-if="isOrder" class="navbar">
      <a href="/" class="navbar-logo">Pillar<span>Tasty</span></a>

      <div class="navbar-nav">
        <a href="/"> Home </a>
        <a href="/menu"> menu </a>
        <!-- <a v-if="orders" href="/order"> orders </a> -->
        <!-- <a href="#about"> tentang kami </a> -->
        <!-- <a href="#contact"> kontak </a> -->
      </div>

      <div class="navbar-extra">
        <a href="/menu" id="search"><i data-feather="book-open"></i></a>
        <a href="/order" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
      </div>
    </nav>
    <RouterView />
    <footer id="footer" class="footer">
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <h5 class="text-uppercase"></h5>
        <ul class="list-unstyled">
          <!-- Instagram Icon -->
          <li>
            <a href="https://www.instagram.com/pilartasty/" target="_blank">
              <i class="fab fa-instagram"></i> 
            </a>
          </li>

          <!-- WhatsApp Icon -->
          <li>
            <a href="https://wa.me/6289510337941" target="_blank">
              <i class="fab fa-whatsapp"></i> 
            </a>
          </li>

          <!-- Location Icon -->
          <li>
            <a href="https://maps.app.goo.gl/gBFkyqaBrRnG2VMi8?g_st=ac" target="_blank">
              <i class="fas fa-map-marker-alt"></i>
            </a>
          </li>

          <!-- Email Icon -->
          <li>
            <a href="mailto:pilartasty66@gmail.com" class="email-link">
              <i class="fas fa-envelope"></i> 
            </a>
          </li>
        </ul>
         <p class="copyright-text">&copy; 2025 Pilar Tasty. All rights reserved.</p>
      </div>
    </div>
  </div>
  </footer>
  </div>
</template>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  outline: none;
  border: none;
  text-decoration: none;
}

body {
  font-family: "poppins", sans-serif;
  background-color: gray;
  /* min-height: 1900px; */
}

.navbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.4rem 7%;
  background-color: rgba(255, 255, 255, 0.708);
  border-bottom: 1px solid #8e6a46;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  z-index: 999;
}

@media (max-width: 768px) {
  .navbar .navbar-nav {
    display: none; /* Hide navbar-nav in mobile view */
  }
}

.navbar .navbar-logo {
  font-size: 2rem;
  font-weight: 700;
  color: black;
}

.navbar .navbar-logo span {
  color: #df113c;
}

.navbar .navbar-nav a {
  color: black;
  display: inline-block;
  font-size: 1.4rem;
  margin: 0 1rem;
}

.navbar .navbar-nav a:hover {
  color: #df113c;
}

.navbar .navbar-nav a::after {
  content: "";
  display: block;
  padding-bottom: 0.5rem;
  border-bottom: 0.1rem solid #df113c;
  transform: scaleX(0);
  transition: 0.2s linear;
}

.navbar .navbar-nav a:hover::after {
  transform: scaleX(0.5);
}

.navbar .navbar-extra a {
  color: #000000;
  margin: 0 0.5rem;
}

.navbar .navbar-extra a:hover {
  color: #df113c;
}

.footer i {
      font-size: 30px;  /* Sesuaikan ukuran ikon */
      margin-right: 15px; /* Jarak antar ikon */
      color: #333;  /* Ubah warna ikon jika diinginkan */
      transition: color 0.3s ease;  /* Efek transisi saat hover */
       
    }

    /* Menata ikon sosial media ke samping */
    .footer ul {
      display: flex;
     /* padding-left: 0;*/
      justify-content: center;
      align-items: center;
      margin: 45px 0;

    }

    .footer ul li {
      list-style: none;
    }

    /* Menambah efek saat hover */
    .footer i:hover {
      color: #007bff; /* Ganti dengan warna hover yang diinginkan */
    }
    .copyright-text {
      text-align: center;  /* Menempatkan teks di tengah */
      margin-top: 15px;  /* Memberikan jarak antara ikon dan teks */
      color: #333;  /* Ganti dengan warna teks yang diinginkan */
      font-size: 14px;  /* Ukuran font teks copyright */
      margin-top: 45px;
    }
</style>

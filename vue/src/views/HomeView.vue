<template>
  <body>
    <!-- Hero Section dengan animasi -->
    <section id="home" class="hero come">
      <main class="content">
        <h1>Selamat datang di <span>PillarTasty</span></h1>
        <p style="margin-top: 160px;">
          Restoran spesialis snack yang menawarkan pengalaman kuliner unik dan lezat terbuat dari ayam yang berkualitas.
          Terletak di Jl Rungkut Permai VII i-6, Surabaya, restoran ini menjadi tujuan favorit bagi pecinta makanan Asia.
        </p>
        <a class="cta" href="/menu">beli sekarang</a>
      </main>
    </section>

    <!-- About Section dengan animasi -->
    <section id="about" class="about scroll-animate">
      <h2><span>Tentang</span> kami</h2>
      <div class="row">
        <div class="about-img scroll-animate">
          <img src="/img/IMG_20250108_130054.jpg" alt="Tentang kami" />
        </div>
        <div class="content scroll-animate">
          <p class="scroll-text">Selamat datang di PillarTasty! Kami adalah restoran spesialis snack yang berdedikasi memberikan pengalaman kuliner yang unik dan lezat. Dibuat dengan penuh cinta, camilan kami dirancang untuk memenuhi selera Anda, dari yang ringan hingga menggugah selera.</p>
          <h3>Kenapa memilih beli camilan di kami?</h3>
          <!-- Paragraf yang akan muncul satu per satu -->
          <p class="scroll-text">Karena kami menggunakan daging ayam berkualitas
            <!-- 100% Homemade, Kami juga sangat ramah dengan customer kami, kami siap layani 24 jam, Proses pembuatan cepat, Harga kompetitif, Tanpa bahan pengawet -->
          </p>
          <p class="scroll-text">100% Homemade</p>
          <p class="scroll-text">Kami juga sangat ramah dengan customer kami, kami siap layani 24 jam</p>
          <p class="scroll-text">Proses pembuatan cepat</p>
          <p class="scroll-text" style="margin-bottom: 12rem;">Harga kompetitif</p>
          <!-- <p class="scroll-text">Tanpa bahan pengawet</p> -->
        </div>
      </div>
    </section>

    <!-- Bisa tambahkan section lainnya seperti Menu, Contact, dll. dengan animasi yang sama -->
  </body>
</template>

<script setup>
import { onMounted, onBeforeUnmount } from 'vue';

// Function to check if an element is in the viewport
const isElementInViewport = (el) => {
  const rect = el.getBoundingClientRect();
  return (
    rect.top < (window.innerHeight || document.documentElement.clientHeight) &&
    rect.bottom > 0
  );
};

// Function to handle scroll and trigger animations
const handleScroll = () => {
  const elements = document.querySelectorAll('.scroll-animate');
  elements.forEach((el) => {
    if (isElementInViewport(el) && !el.classList.contains('animated')) {
      el.classList.add('animated');
    }
  });

  // Animate each paragraph in the About section
  const textElements = document.querySelectorAll('.scroll-text');
  textElements.forEach((el, index) => {
    if (isElementInViewport(el) && !el.classList.contains('text-animated')) {
      el.classList.add('text-animated');
      el.style.animationDelay = `${1.5 + index * 0.5}s`; // Dynamic stagger delay
    }
  });
};

// Debounced scroll listener
let scrollTimeout;
const debouncedScroll = () => {
  clearTimeout(scrollTimeout);
  scrollTimeout = setTimeout(handleScroll, 100);
};

// Lifecycle hooks
onMounted(() => {
  window.addEventListener('scroll', debouncedScroll);
  handleScroll(); // Initial check for visible elements
});

onBeforeUnmount(() => {
  window.removeEventListener('scroll', debouncedScroll);
});
</script>

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
  min-height: 100px;
}

@keyframes comeAnimation {
  from {
    opacity: 0;
    transform: translateY(50px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Apply animation to .come */
.come {
  opacity: 0; /* Ensure the element is initially hidden */
  animation: comeAnimation 1.5s ease-out forwards;
}

.scroll-animate {
  opacity: 0;
  transform: translateY(30px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}

.scroll-animate.animated {
  opacity: 1;
  transform: translateY(0);
}

.scroll-text {
  opacity: 0;
  transform: translateY(20px);
  transition: opacity 1s ease-out, transform 1s ease-out;
}

.scroll-text.text-animated {
  opacity: 1;
  transform: translateY(0);
}

/* Hero Section */
.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  background-image: url("/img/WhatsApp Image 2025-01-08 at 08.53.02.jpeg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  position: relative;
  color: white;
}

.hero .content {
  padding: 1.4rem 7%;
  max-width: 60rem;
}

.hero .content h1 {
  font-size: 5rem;
  color: white;
  position: absolute;
  top: 15rem;
  line-height: 1.2;
}

.hero .content h1 span {
  color: #df113c;
}

.hero .content p {
  font-size: 1.6rem;
  margin-top: 8rem;
  line-height: 1.4;
  font-weight: 40;
  text-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
}

.cta {
  margin-top: 1rem;
  display: inline-block;
  padding: 1rem 3rem;
  font-size: 1.4rem;
  color: white;
  background-color: #df113c;
  border-radius: 0.5rem;
  box-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
}

.cta:hover{
  cursor: pointer;
  background-color: #960020;
  transition: 350ms;
}

/* About Section */
.about {
  background-color: white;
}

.about,
.menu,
.contact {
  padding: 10rem 7% 1.4rem;
}

.about h2,
.menu h2,
.contact h2 {
  text-align: center;
  font-size: 2.6rem;
  margin-bottom: 3rem;
  color: #df113c;
}

.about h2 span,
.menu h2 span,
.contact h2 span {
  color: black;
}

.about .row {
  display: flex;
}

.about .row .about-img {
  flex: 1 1 45rem;
}

.about .row .about-img img {
  width: 100%;
}

.about .row .content {
  flex: 1 1 35;
  padding: 0 1rem;
}

.about .row .content h3 {
  font-size: 1.8rem;
  margin-bottom: 1rem;
  color: black;
}

.about .row .content p {
  margin-bottom: 0.8rem;
  font-size: 1.3rem;
  line-height: 1.6;
  color: black;
}

.menu h2,
.contact h2 {
  margin-bottom: 1rem;
}

.menu p,
.contact p {
  text-align: center;
  max-width: 30rem;
  margin: auto;
  line-height: 1.6rem;
  color: white;
}

.menu .row {
  display: flex;
  flex-wrap: wrap;
  margin-top: 5rem;
  justify-content: center;
}

.menu .row .menu-card {
  text-align: center;
}

.menu .row .menu-card img {
  border-radius: 50%;
  width: 80%;
}

.menu .row .menu-card .menu-card-tittle {
  margin: 1rem auto 0.5rem;
}

.contact .row {
  display: flex;
  margin-top: 2rem;
}

.contact .row form {
  flex: 1 1 45rem;
  padding: 5rem 2rem;
  text-align: center;
}

.contact .row form .input-group {
  display: flex;
  align-items: center;
  margin-top: 2rem;
  border: 1px solid #eee;
  padding-left: 2rem;
}

.contact .row form .input-group input {
  width: 100%;
  padding: 2rem;
  font-size: 1.7rem;
  background: none;
}

.contact .row .map {
  flex: 1 1 45rem;
  width: 100%;
  object-fit: cover;
}
</style>

<script setup>

</script>

<template>
  <body>
  <section class="hero" id="home">
      <main class="content">
        <h1>Selamat datang di <span>PillarTasty</span></h1>
        <p>
          Restoran spesialis snack yang menawarkan pengalaman kuliner unik dan lezat terbuat dari ayam yang berkualitas.
          Terletak di Jl Rungkut Permai VII i-6, Surabaya, restoran ini menjadi tujuan favorit bagi pecinta makanan Asia.
        </p>
        <a href="index.html" class="cta">beli sekarang</a>
      </main>
    </section>

    <section id="about" class="about">
      <h2><span>Tentang</span> kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="../components/IMG_20250108_130054.jpg" alt="Tentang kami" />
        </div>
        <div class="content">
          <h3>Kenapa memilih beli camilan di kami?</h3>
          <p>
            Karena kami menggunakan daging ayam berkualitas
          </p>
          <p>
            kami juga beredia mengirim ketempat costomer kami dengan biaya ongkir yang terjangkau
          </p>

          <p>
            Kami juga sangat ramah dengan costomer kami kami siap layani 24 jam
          </p>
        </div>
      </div>
    </section>
  </body>
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
  min-height: 1900px;
}

.hero {
  min-height: 100vh;
  display: flex;
  align-items: center;
  background-image: url("../components/img/WhatsApp Image 2025-01-08 at 08.53.02.jpeg");
  background-repeat: no-repeat;
  background-size: cover;
  background-position: center;
  position: relative;
  color: white;
}

.hero::after {
  content: "";
  display: block;
  position: absolute;
  width: 100%;
  height: 30%;
  bottom: 0;
  /* background: linear-gradient(
    0deg,
    rgb(1, 1, 3, 1) 8%,
    rgba(255, 255, 255, 0) 50%
  ); */
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
  position: relative;
  left: 0;
}

.hero .content p {
  font-size: 1.6rem;
  margin-top: 15rem;
  line-height: 1.4;
  font-weight: 400;
  text-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
}

.hero .content .cta {
  margin-top: 1rem;
  display: inline-block;
  padding: 1rem 3rem;
  font-size: 1.4rem;
  color: white;
  background-color: #df113c;
  border-radius: 0.5rem;
  box-shadow: 1px 1px 3px rgba(1, 1, 3, 0.5);
}

.hero .content .cta:hover{
  background-color: white;
  color: black;
}

.about{
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
  /* background-color: var(--bg); */
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

button {
  margin-top: 15px;
  width: 80%;
  font-size: 2q rem;
  background: none;
  background-color: #2f4858;
  border: 1px solid #eee;
  padding: 2rem;
}
</style>
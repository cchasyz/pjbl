<script setup>
import { onMounted } from 'vue';


onMounted(() => {
  feather.replace();
});
</script>

<template>
  <div>
    <nav class="navbar">
      <a href="/" class="navbar-logo">Pillar<span>Tasty</span></a>

      <div class="navbar-nav">
        <a href="/"> Home </a>
        <a href="#about"> tentang kami </a>
        <a href="/menu"> menu </a>
        <a href="#contact"> kontak </a>
      </div>

      <div class="navbar-extra">
        <a href="" id="search"><i data-feather="search"></i></a>
        <a href="/menu" id="shopping-cart"><i data-feather="shopping-cart"></i></a>
      </div>
    </nav>
    <RouterView />
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
  min-height: 1900px;
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
  z-index: 9999;
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
</style>

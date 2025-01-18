<script setup>
import short from '@/router/axios';
import { ref, onMounted } from 'vue';

const nameinput = ref('');
const registered = ref(false);
const skipNameInput = ref(false);
const username = ref('');
const selectedCategory = ref('ALL');
const foodCount = ref();
const Isicart = ref(false);

onMounted(()=>{
  const loggedin = ref();
  loggedin.value = localStorage.getItem('name');
  if(loggedin.value){
    skipNameInput.value = true;
  } else {
    skipNameInput.value = false;
  }
  const foods = ref();
  foods = JSON.parse(localStorage.getItem('food'));
  if(foods.value){
    Isicart.value = true;
  } else {
    Isicart.value = false;
  }
})

function move() {
  window.location.href = '/order';
}

const foods = [
  { name: 'Tahu Bakso isi 5', price: 15000, pic: '/img/tahu.jpg', category: 'Favorites' },
  { name: 'Gyoza isi 5', price: 15000, pic: '/img/gyioza.jpg', category: 'Best Seller' },
  { name: 'Siomay Goreng isi 10', price: 20000, pic: '/img/IMG_20250108_125103.jpg', category: 'Favorites' },
  { name: 'Lumpia Kulit Tahu isi 5', price: 15000, pic: '/img/lumpia.jpg', category: 'Best Seller' },
  { name: 'Lumpia Ayam isi 10', price: 30000, pic: '/img/IMG_20250108_130259.jpg', category: 'Favorites' },
  { name: 'Sempol Ayam isi 10', price: 20000, pic: '/img/IMG_20250108_125006.jpg', category: 'Best Seller' },
  { name: 'Tahu Walik isi 10', price: 20000, pic: '/img/IMG_20250108_131446.jpg', category: 'ALL' },
  { name: 'Odeng 1 cup', price: 15000, pic: '/img/IMG_20250108_130357.jpg', category: 'ALL' },
];

const input = async()=>{
  username.value = localStorage.getItem('name');
  try{
    const res = await short.post('/userdata', {
      name: skipNameInput.value ? username.value : nameinput.value
    });
    registered.value = true;
    localStorage.setItem('name', res.data.data.name);
  }catch(error){
    console.error(error);
  }
}

function masukkanMakananKeOrder(food, price, pic) {
  const modal = document.getElementById('confirmationModal');
  modal.style.display = 'flex';
  document.body.classList.add('modal-open'); 

  document.getElementById('confirmYes').onclick = async() => {
    if(!skipNameInput){
    if(!nameinput.value){
      alert('isi nama dahulu');
      return
    }}
    
    await input();
    
    username.value = localStorage.getItem('name');
    const getFoods = JSON.parse(localStorage.getItem('food')) || [];
    const findFoods = getFoods.find((item) => item.name === username.value && item.foodtype === food);

    if (!findFoods) {
      getFoods.push({ name: username.value, foodtype: food, price: price, pic: pic, count: 1 });
    } else {
      findFoods.count += 1;
    }

    localStorage.setItem('food', JSON.stringify(getFoods));

    const totalCount = getFoods
    .filter(item => item.name === username.value)
    .reduce((sum, item) => sum + parseInt(item.count, 10), 0);

    foodCount.value = totalCount;
    Isicart.value = true;

    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); 
  };

  document.getElementById('confirmNo').onclick = () => {
    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); 
  };
}

function filterFoods(category) {
  selectedCategory.value = category;
}
</script>

<template>
  <body>

<div id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Do you want to add this item to the cart?</p>
    <div v-if="!skipNameInput">
    <input style="margin: 20px 0 0; border: 1px solid black; padding: 5px;" type="text" 
    placeholder="name..." v-model="nameinput">
    </div>
    <button id="confirmYes">Yes</button>
    <button id="confirmNo">No</button>
  </div>
</div>


    <div class="dashboard">
          <div class="dashboard-banner">
               <img src="/images/images-banner-2.jpg">
               <div class="banner-promo">
                    <h1><span>50% OFF</span><br>
                    Tasty Food <br> On Your Hand </h1>
               </div>
         </div>

         <h3 class="dashboard-tittle">Recommend Food For You</h3>
      <div class="dashboard-menu">
        <a href="#" @click.prevent="filterFoods('Favorites')">Favorites</a>
        <a href="#" @click.prevent="filterFoods('Best Seller')">Best Seller</a>
        <a href="#" @click.prevent="filterFoods('ALL')">ALL</a>
      </div>

      <div class="dashboard-content">
        <div v-for="food in foods.filter(food => selectedCategory === 'ALL' || food.category === selectedCategory)" :key="food.name" class="dashboard-card" @click.prevent="masukkanMakananKeOrder(food.name, food.price, food.pic)">
          <img class="card-images" :src="food.pic" />
          <div class="card-detail">
            <h4>{{ food.name }} <span>RP {{ food.price }} </span></h4>
            <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
          </div>
        </div>
      </div>
    </div>

    <div class="shopping_button" v-if="Isicart">
      <div>shopping cart</div> items - {{ foodCount }} <button @click.prevent="move" class="thebtn">cart</button>
    </div>

  </body>
</template>

<style scoped>
.shopping_button{
  display: flex;
  justify-content:space-around;
  align-items: center;
  background-color: #df113c;
  position: fixed;
  bottom: 0;
  width: 100vw;
  padding: 13px 0;
  color: white;
  font-size: 1.5rem;
}

.thebtn{
  background-color: white;
  color: black;
  font-size: 1.5rem;
  padding: 5px 15px;
  border-radius: 15px;
}

.thebtn:hover{
  background-color: #28a745;
  color: white;
  transition: 300ms;
  cursor: pointer;
}

.modal {
  display: none; /* Hidden by default */
  position: fixed; /* Fixed position to overlay the whole viewport */
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Dimmed background */
  justify-content: center;
  align-items: center;
  z-index: 99999;
  overflow: hidden; /* Prevents modal content from being scrolled out */
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  text-align: center;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
  width: 90%; /* Responsive width */
  max-width: 400px; /* Limit for larger screens */
  box-sizing: border-box;
}

body.modal-open {
  overflow: hidden; /* Prevent scrolling on body when modal is active */
}

@media screen and (max-width: 768px) {
  .modal-content {
    width: 80%; /* Adjust modal size for mobile */
  }
}

.modal button {
  padding: 8px 13px;
  margin: 1.5rem 0.4rem 0;
  cursor: pointer;
  border-radius: 5px;
}

button#confirmYes {
  background-color: #28a745;
  color: white;
}
button#confirmYes:hover {
  background-color: #008d21;
  color: white;
  transition: 300ms;
}

button#confirmNo {
  background-color: #dc3545;
  color: white;
}
button#confirmNo:hover {
  background-color: #c10013;
  color: white;
  transition: 300ms;
}

* {
  font-family: "Noto Sans JP", sans-serif;
}

/* Add this to your existing styles */
.fas {
  font-family: "Font Awesome 5 Free"; /* Ensure the correct font is applied */
  font-weight: 900; /* FontAwesome icons are using a heavy font-weight */
  font-size: 1.2rem; /* Adjust the size of the icon */
  color: #61666b; /* Or whatever color you prefer */
}

/* Add any other icon-specific styling if needed */
.fas.fa-clock,
.fas.fa-map-marker-alt {
  display: inline-block;
  vertical-align: middle;
}

body {
  width: 100%;
  margin-top: 5rem;
  height: auto;
  color: #2d2f31;
  background-color:#b4b4b4;
}

p {
  font-size: 14px;
}

.label-cart {
  position: fixed;
  top: 15px;
  right: 10;
  z-index: 4;
  cursor: pointer;
}

.logo {
  position: fixed;
  background-color: #2d2f31;
  color: #f2f2f2;
  width: 100%;
  text-align: center;
  padding: 15px 420px 15px 60px;
  top: 0;
  z-index: 2;
}

.dashboard {
  height: 100%;
  width: 100%;
  /* padding-right: 360px; */
  /* padding-left: 60px; */
}

.dashboard-banner {
  width: 100%;
  height: 300px;
  position: relative;
  margin-top: 4rem;
  padding: 1rem;
  border-radius: 30px;
  cursor: pointer;
}

.dashboard-banner > img {
 width: 100%; 
 height: 100%;
 object-fit: cover;
 border-radius: 30px;
}

.banner-promo {
  position: absolute;
  color: #f2f2f2;
  top: 15%;
  left: 10%;
  font-weight: 800;
}

.banner-promo > h1 > span {
  color: #fecb40;
}

.dashboard-tittle {
  padding: 0 1rem;
}

.dashboard-menu {
  display: flex;
  gap: 10px;
  padding: 0.3rem 1rem;
  overflow-x: auto;
}

.dashboard-menu > a {
  text-decoration: none;
  text-align: center;
  border-radius: 20px;
  min-width: 120px;
  padding: 0.5rem;
  font-size: 0.9rem;
  color: #000000;
  background-color: #f2f2f2;
}

.dashboard-menu > a:hover {
  background-color: #df113c;
  color: #f2f2f2;
  transition:350ms ;
}

.dashboard-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  padding: 0.5rem 1rem 1rem 1rem;
}

.dashboard-card {
  background-color: #d8d8d8;
  box-shadow: rgba(0, 0, 0, 0.16) 0px 1px 4px;
  border-radius: 15px;
  position: relative;
  cursor: pointer;
}

.card-images { /* satu kali sudah cukup */
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 15px;
}

.dashboard-card:hover {
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}

.card-detail {
  padding: 10px;
}

.card-detail >h4 >span {
  float: right;
}

.card-time {
  color: #61666b;
  font-size: 0.8rem;
  padding-top: 10px;
}
.dashboard-order {
  width: 340px;
  min-height: 100%;
  position:fixed;
  top: 0;
  right: 0;
  padding: 0.5rem 1.5rem;
  background-color: #f6f8fa;
  z-index: 9999;
}

.dashboard-order > h3 {
  padding: 10px 0;
}

.order-address > h4 {
  line-height: 2;
}

.order-time {
  font-size: 0.8rem;
  color: #61666b;
}

.order-wrapper {
  height: 180px;
  width: 100%;
  overflow-y:scroll;
  margin: 20px 0;
}

/* custom scroll */

.order-wrapper::-webkit-scrollbar {
  width: 7px;
}

.order-wrapper::-webkit-scrollbar-track {
  background-color: #f2f2f2;
  border-radius: 20px;
}

.order-wrapper::-webkit-scrollbar-thumb {
  background-color: #61666b;
  border-radius: 20px;
}

.order-card {
  display: grid;
  grid-template-columns: 0.6fr 1fr 0.5fr;
  padding: 10px 0;
  gap: 5px;
  justify-content: space-around;
  align-items: flex-start;
}

.order-image {
   width: 70px;
   height: 70px;
   object-fit: cover;
   border-radius: 15px;
}

.order-detail > input {
  width: 35px;
  height: 35px;
  text-align: center;
  border: 2px solid #d5d5d5;
  border-radius: 10px;
  background-color: transparent;
  margin-left: 10px;
}

.divider {
  width: 100%;
  border: 1px dashed #d5d5d5;
}

.order-total > p {
  padding: 10px 0;
}

.order-total > p > span {
  float: right;
  font-weight: 600;
}

.order-promo {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f2f2f2;
  border: 2px solid #d5d5d5;
  border-radius: 10px;
  height: 45px;
  padding: 0.5px;
  margin: 5px 0 10px 0;
}

.input-promo {
  height: 100%;
  background-color: transparent;
  border: none;
}

.button-promo {
  float: right;
  background-color: #fecb40;
  border: none;
  border-radius: 5px;
  height: 50%;
  width: 100%;
  cursor: pointer;
}

.checkout {
  width: 100%;
  height: 40px;
  text-align: center;
  background-color: #df113c;
  border: none;
  border-radius: 20px ;
  color: #f2f2f2;
  cursor: pointer;
}

.checkout:hover {
  text-transform: uppercase;
  font-weight: 600;
}

#cart {
  display: none;
}

#cart:checked ~ .label-cart {
  color: #f2f2f2;
}

#cart:checked ~ .dashboard {
  padding-right: 10px;
}

#cart:checked ~ .dashboard-order {
  display: none;
}

#cart:checked ~ .logo {
  padding-right: 0px;
} 
</style>
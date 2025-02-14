<script setup>
import short from '@/router/axios';
import { ref, onMounted } from 'vue';

const nameinput = ref(null);
const registered = ref(false);
const skipNameInput = ref(false);
const username = ref('');
const foods = ref([]);
const selectedCategory = ref('ALL');
const foodCount = ref();
const Isicart = ref(false);
const loggedin = ref();
const food = ref();
const adminCheck = ref(false);
const confirmAction = ref(null); 
const adminOutput = ref();
const tambah = ref(false);
const updateWindow = ref(false);
const selectedFile = ref(null);
const nameInput = ref();
const priceInput = ref();
const categoryInput = ref();
const updatenameinput = ref();
const updatepriceinput = ref();

const handleFileUpload = (event) => {
  selectedFile.value = event.target.files[0];
  console.log('Selected file:', selectedFile.value);
};

const addmenu = async()=>{
  const formData = new FormData();
  
  formData.append('name', nameInput.value);
  formData.append('price', priceInput.value);
  formData.append('category', categoryInput.value);
  formData.append('pic', selectedFile.value);
  try {
    const res = await short.post('/createMenu', formData, {
      headers: { 'Content-Type': 'multipart/form-data' },
    });
    console.log(res);
  } catch (error) {
    console.error(error);
  }
  getMenu()
};

const getMenu = async()=>{
    try{
      const res = await short.get('/getMenu');
      foods.value = res.data.data;
    }catch(error){
      console.error(error);
    }
}

onMounted(async()=>{
  
  await getMenu();
  
  loggedin.value = localStorage.getItem('name');
  if(loggedin.value){
    skipNameInput.value = true;
  } else {
    skipNameInput.value = false;
  }
  food.value = JSON.parse(localStorage.getItem('food'));
  if(food.value){
    Isicart.value = true;
  } else {
    Isicart.value = false;
  }
  adminCheck.value = localStorage.getItem('admin');
  console.log(adminCheck.value);
  
  username.value = localStorage.getItem('name');
  if(username.value !== null){
    if(adminCheck){
      return
    }
    const getFoods = JSON.parse(localStorage.getItem('food'));
    const totalCount = getFoods
      .filter(item => item.name === username.value)
      .reduce((sum, item) => sum + parseInt(item.count, 10), 0);
      if(totalCount !== 0){
        foodCount.value = totalCount;
      } else {
        Isicart.value = false;
      }
  }
})

const input = async()=>{
  username.value = localStorage.getItem('name');
  try{
    const res = await short.post('/userdata', {
      name: skipNameInput.value ? username.value : nameinput.value
    });
    registered.value = true;
    localStorage.setItem('name', res.data.data.name);
    adminCheck.value = res.data.data.is_admin;
    localStorage.setItem('admin', adminCheck.value);
  }catch(error){
    console.error(error);
  }
}

function masukkanMakananKeOrder(name, price, pic) {
  if(adminCheck.value){
    adminOutput.value = name
  }
  
  const modal = document.getElementById('confirmationModal');
  modal.style.display = 'flex';
  document.body.classList.add('modal-open'); 

  confirmAction.value = async () => {
    if (nameinput.value === null && !skipNameInput.value || nameinput.value === '' && !skipNameInput.value) {
      alert('Isi nama dahulu');
      return;
    }
    
    await input();
    
    if (adminCheck.value) {
      modal.style.display = 'none';
      document.body.classList.remove('modal-open');
      skipNameInput.value = true;
      return;
    }
    
    username.value = localStorage.getItem('name');
    const getFoods = JSON.parse(localStorage.getItem('food')) || [];
    const findFoods = getFoods.find((item) => item.name === username.value && item.foodtype === name);

    if (!findFoods) {
      getFoods.push({ name: username.value, foodtype: name, price: price, pic: pic, count: 1 });
    } else {
      findFoods.count += 1;
    }

    localStorage.setItem('food', JSON.stringify(getFoods));

    const totalCount = getFoods
      .filter((item) => item.name === username.value)
      .reduce((sum, item) => sum + parseInt(item.count, 10), 0);

    foodCount.value = totalCount;
    Isicart.value = true;
    skipNameInput.value = true;

    modal.style.display = 'none';
    document.body.classList.remove('modal-open');
  };
}

const confirmYes = () => {
  if (confirmAction.value) {
    confirmAction.value();
  }
};

const confirmNo = () => {
  const modal = document.getElementById('confirmationModal');
  modal.style.display = 'none';
  updateWindow.value = false;
  document.body.classList.remove('modal-open');
};

const deleteFood = async(name)=>{
  const modal = document.getElementById('confirmationModal');
  try{
    await short.delete(`/deleteMenu/${name}`);
    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); 
    getMenu()
  }catch(error){
    console.error(error);
    
  }
}

const updateFood = async(name)=>{
  const modal = document.getElementById('confirmationModal');
  try{
    await short.put(`/updateMenu/${name}`, {
      'name': updatenameinput.value,
      'price': updatepriceinput.value
    });
    modal.style.display = 'none';
    document.body.classList.remove('modal-open'); 
    getMenu()
  }catch(error){
    console.error(error);
  }
}

function filterFoods(category) {
  selectedCategory.value = category;
}

const update = ()=>{
  const modal = document.getElementById('confirmationModal');
  updateWindow.value = true;
  modal.style.display = 'flex'
}
</script>

<template>
  <body>

<div v-if="adminCheck == 0 | !adminCheck" id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>Do you want to add this item to the cart?</p>
    <div v-if="!skipNameInput">
    <input style="margin: 20px 0 0; border: 1px solid black; padding: 5px;" type="text" 
    placeholder="name..." v-model="nameinput">
    </div>
    <button @click.prevent="confirmYes" class="confirmYes">Yes</button>
    <button @click.prevent="confirmNo" class="confirmNo">No</button>
  </div>
</div>


<div v-if="adminCheck == 1" id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>{{adminOutput}}</p>
    <div v-if="!skipNameInput">
    <input style="margin: 20px 0 0; border: 1px solid black; padding: 5px;" type="text" 
    placeholder="name..." v-model="nameinput">
    </div>

    <div v-if="!updateWindow">
      <button class="confirmYes" @click.prevent="update">update menu</button>
      <button class="confirmNo" @click.prevent="deleteFood(adminOutput)">delete menu</button>
    </div>

    <div v-else style="
    display: flex;
    flex-direction: column;
    width: 50%;
    margin: 7% 0 0 25%;
    ">
      <label for="text">food name</label>
      <input type="text" v-model="updatenameinput" placeholder="dumpling..." style="border: 1px solid black;">
      <label for="number">price</label>
      <input type="number" placeholder="15000" v-model="updatepriceinput" style="border: 1px solid black;">
      <button class="confirmYes" @click.prevent="updateFood(adminOutput)">update</button>
      <button class="confirmNo" @click.prevent="confirmNo">cancel</button>
    </div>
  </div>
</div>

<div v-if="adminCheck == 1 && updateWindow == true" id="confirmationModal" class="modal">
  <div class="modal-content">
    <p>{{adminOutput}}</p>
    <div v-if="!skipNameInput">
    <input style="margin: 20px 0 0; border: 1px solid black; padding: 5px;" type="text" 
    placeholder="name..." v-model="nameinput">
    </div>
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
        <div v-if="adminCheck == 1" class="dashboard-card" style="align-items: center; align-content: center; text-align: center;" @click.prevent="tambah = true">
        <p v-if="!tambah">
          tambah menu +
        </p>
        <div style="
        display: flex;
        flex-direction: column;
        width: 50%;
        align-items: center;
        margin: 5% 0 0 25% ;
        "
        v-if="tambah">
          <label for="text">Food name</label>
          <input type="text" v-model="nameInput" placeholder="dumpling...">
          <label for="int">Food price</label>
          <input type="number" v-model="priceInput" placeholder="15000">
          <label for="select">Category</label>
          <select v-model="categoryInput">
            <option value="All">All</option>
            <option value="Favorites">Favorites</option>
            <option value="Best Seller">Best Seller</option>
          </select>
          <label for="file-upload">Upload Image</label>
          <input id="file-upload" type="file" @click.stop @change="handleFileUpload">
          <button class="addbtn" @click.prevent="addmenu">add</button>
        </div>
        </div>
      </div>
    </div>

    <div class="shopping_button" v-if="Isicart">
      <div>shopping cart</div> items - {{ foodCount }} <a href="/order" class="thebtn">cart</a>
    </div>

  </body>
</template>

<style scoped>
.addbtn{
  padding: 3px 15px;
  border: 1px solid black;
  cursor: pointer;
}
.addbtn:hover{
  color: white;
  background-color: #df113c;
  transition: 300ms;
}
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

button.confirmYes {
  background-color: #28a745;
  color: white;
}
button.confirmYes:hover {
  background-color: #008d21;
  color: white;
  transition: 300ms;
}

button.confirmNo {
  background-color: #dc3545;
  color: white;
}
button.confirmNo:hover {
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
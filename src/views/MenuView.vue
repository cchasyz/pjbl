<script setup> 
import { ref } from 'vue';

const foods = ref(null);
// [tahuBakso, gyoza, siomay, lumpiaKulit, lumpiaAyam, sempolAyam, tahuWalik, odeng]
 
 function masukkanMakananKeOrder(makanan){
    const getFoods = JSON.parse(localStorage.getItem('food'));
        if(!getFoods){
            localStorage.setItem('food', JSON.stringify([{id: makanan, count: 1}]));
            foods.value = JSON.parse(localStorage.getItem('food'));
            return
        }
        const findFoods = getFoods.find((item)=>{
        return item.id === makanan
        })
        if(!findFoods){
            getFoods.push({id: makanan, count: 1});
            localStorage.setItem('food', JSON.stringify(getFoods))
            foods.value = ref([JSON.parse(localStorage.getItem('food'))]);
            return
        }
        findFoods.count += 1;
        localStorage.setItem('food', JSON.stringify(getFoods));
        foods.value = ref([JSON.parse(localStorage.getItem('food'))]);
        return
    }
</script>

<template>
  <body>
    <div class="dashboard" v-if="foods == null">
          <div class="dashboard-banner">
               <img src="../components/images/images-banner-2.jpg">
               <div class="banner-promo">
                    <h1><span>50% OFF</span><br>
                    Tasty Food <br> On Your Hand </h1>
               </div>
         </div>

         <h3 class="dashboard-tittle">Recommend Food For You</h3>
         <div class="dashboard-menu">
            <a href="#">Favorites</a>
            <a href="#">Best Seller</a>
            <a href="#">Near me</a>
            <a href="#">Promotion</a>
            <a href="#">Top Rated</a>
            <a href="#">ALL</a>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(1), console.log(foods.value)">
                <img class="card-images" src="../components/img/tahu.jpg">
                <div class="card-detail">
                     <h4>Tahu Bakso isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
           <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(2)">
                <img class="card-images" src="../components/img/gyioza.jpg">
                <div class="card-detail">
                     <h4>Gyoza isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
            <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(3)">
                 <img class="card-images" src="../components/img/IMG_20250108_125103.jpg">
                 <div class="card-detail">
                     <h4>Siomay Goreng isi 10 <span>RP 20000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                  </div>
            </div>
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(4)">
                  <img class="card-images" src="../components/img/lumpia.jpg">
                  <div class="card-detail">
                     <h4>Lumpia Kulit Tahu isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                 <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(5)">
                 <img class="card-images" src="../components/img/IMG_20250108_130259.jpg">
                 <div class="card-detail">
                     <h4>Lumpia Ayam isi 10 <span>RP 30000</span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                 <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(6)">
                 <img class="card-images" src="../components/img/IMG_20250108_125006.jpg">
                 <div class="card-detail">
                     <h4>Sempol Ayam isi 10 <span>RP 20000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(7)">
                  <img class="card-images" src="../components/img/IMG_20250108_131446.jpg">
                  <div class="card-detail">
                      <h4>Tahu Walik isi 10<span>RP 20000 </span></h4>
                      <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                </div>
            </div> 
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(8)">
                  <img class="card-images" src="../components/img/IMG_20250108_130357.jpg">
                  <div class="card-detail">
                      <h4>Odeng 1 cup<span>RP 15000 </span></h4>
                      <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                </div>
            </div> 
        </div>
</div>
<div v-if="foods !== null" class="dashboard" style="padding-right:360px;">
    <div class="dashboard-banner">
               <img src="../components/images/images-banner-2.jpg">
               <div class="banner-promo">
                    <h1><span>50% OFF</span><br>
                    Tasty Food <br> On Your Hand </h1>
               </div>
         </div>

         <h3 class="dashboard-tittle">Recommend Food For You</h3>
         <div class="dashboard-menu">
            <a href="#">Favorites</a>
            <a href="#">Best Seller</a>
            <a href="#">Near me</a>
            <a href="#">Promotion</a>
            <a href="#">Top Rated</a>
            <a href="#">ALL</a>
        </div>

        <div class="dashboard-content">
            <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(1), console.log(foods.value)">
                <img class="card-images" src="../components/img/tahu.jpg">
                <div class="card-detail">
                     <h4>Tahu Bakso isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
           <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(2)">
                <img class="card-images" src="../components/img/gyioza.jpg">
                <div class="card-detail">
                     <h4>Gyoza isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
            <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(3)">
                 <img class="card-images" src="../components/img/IMG_20250108_125103.jpg">
                 <div class="card-detail">
                     <h4>Siomay Goreng isi 10 <span>RP 20000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                  </div>
            </div>
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(4)">
                  <img class="card-images" src="../components/img/lumpia.jpg">
                  <div class="card-detail">
                     <h4>Lumpia Kulit Tahu isi 5 <span>RP 15000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                 <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(5)">
                 <img class="card-images" src="../components/img/IMG_20250108_130259.jpg">
                 <div class="card-detail">
                     <h4>Lumpia Ayam isi 10 <span>RP 30000</span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                 <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(6)">
                 <img class="card-images" src="../components/img/IMG_20250108_125006.jpg">
                 <div class="card-detail">
                     <h4>Sempol Ayam isi 10 <span>RP 20000 </span></h4>
                     <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                 </div>
            </div>
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(7)">
                  <img class="card-images" src="../components/img/IMG_20250108_131446.jpg">
                  <div class="card-detail">
                      <h4>Tahu Walik isi 10<span>RP 20000 </span></h4>
                      <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                </div>
            </div> 
                  <div class="dashboard-card" @click.prevent="masukkanMakananKeOrder(8)">
                  <img class="card-images" src="../components/img/IMG_20250108_130357.jpg">
                  <div class="card-detail">
                      <h4>Odeng 1 cup<span>RP 15000 </span></h4>
                      <p class="card-time"><span class="fas fa-clock"></span>15-30 mins</p>
                </div>
            </div> 
        </div>

        <div class="dashboard-order" v-if="foods">
        <h3>Order Menu</h3>
        <div class="order-address">
            <h4>Address Dalivery</h4>
            <h4>Jl. Gunung Anyar Harapan ZA-25, Surabaya</h4>
         </div>
         <div class="order-time">
            <span class="fas fa-clock"></span> 30mins <span class="fas fa-map-marker-alt"></span> 2km
         </div> 

         <div>
    <div class="order-wrapper">
        <div class="order-card">
            <img class="order-image" src="../components/images/choco.jpg">
            <div class="order-detail">
                <p>Cookies Choco Chip 
                    isi 5</p>
                <i class="pas fa-times"></i> <input type="text" value="1">
            </div>
            <h4 class="order-price">RP 12.000</h4>
        </div>
        <div class="order-card">
            <img class="order-image" src="../components/images/images6.jpg">
            <div class="order-detail">
                <p>Siomay Mentai 
                    isi 6</p>
                <i class="pas fa-times"></i> <input type="text" value="2">
            </div>
            <h4 class="order-price">RP 6000</h4>
        </div>
    <div class="order-card">
         <img class="order-image" src="../components/images/images14.jpg">
         <div class="order-detail">
            <p>Cookies White Chocolate isi 5</p>
            <i class="pas fa-times"></i> <input type="text" value="1">
       </div>
            <h4 class="order-price">RP 12.000</h4>
        </div>
      </div>
            <hr class="divider">
    <div class="order-total">
         <p>Subtotal <span>RP 24.000</span></p>
         <p>Tax (10%) <span>RP 24.000</span></p>
         <p>Delivery Fee <span>RP 5.000</span></p>

     <div class="order-promo">
         <input class="input-promo" type="text" placeholder="Apply Voucer">
         <button class="button-promo">Find Promo</button>
      </div>
           <hr class="divider">
           <p>Total <span>RP 30.000 </span></p>
      </div>
            <button class="checkout">
                    Checkout
            </button>
   </div>
   <div class="dashboard-order">
        <h3>Order Menu</h3>
        <div class="order-address">
            <h4>Address Dalivery</h4>
            <h4>Jl. Gunung Anyar Harapan ZA-25, Surabaya</h4>
         </div>
         <div class="order-time">
            <span class="fas fa-clock"></span> 30mins <span class="fas fa-map-marker-alt"></span> 2km
         </div> 


    <div class="order-wrapper">
        <div class="order-card">
            <img class="order-image" src="../components/images/choco.jpg">
            <div class="order-detail">
                <p>Cookies Choco Chip isi 5</p>
                <i class="pas fa-times"></i> <input type="text" value="1">
            </div>
            <h4 class="order-price">RP 12.000</h4>
        </div>
        <!-- <div class="order-card">
            <img class="order-image" src="../components/images/images6.jpg">
            <div class="order-detail">
                <p>Siomay Mentai 
                    isi 6</p>
                <i class="pas fa-times"></i> <input type="text" value="2">
            </div>
            <h4 class="order-price">RP 6000</h4>
        </div> -->
    <!-- <div class="order-card">
         <img class="order-image" src="../components/images/images14.jpg">
         <div class="order-detail">
            <p>Cookies White Chocolate isi 5</p>
            <i class="pas fa-times"></i> <input type="text" value="1">
       </div>
            <h4 class="order-price">RP 12.000</h4>
        </div> -->
      </div>
            <hr class="divider">
    <div class="order-total">
         <p>Subtotal <span>RP 24.000</span></p>
         <p>Tax (10%) <span>RP 24.000</span></p>
         <p>Delivery Fee <span>RP 5.000</span></p>

     <div class="order-promo">
         <input class="input-promo" type="text" placeholder="Apply Voucer">
         <button class="button-promo">Find Promo</button>
      </div>
           <hr class="divider">
           <p>Total <span>RP 30.000 </span></p>
      </div>
            <button class="checkout" @click.prevent="foods.value = null, console.log(foods.value)">
                    Checkout
            </button>
   </div>
  </div>
</div>
</body>
</template>

<style scoped>
* {
  font-family: "Noto Sans JP", sans-serif;
}

body {
  width: 100%;
  margin-top: 5rem;
  height: auto;
  color: #2d2f31;
  background-color: rgb(255, 255, 255);
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
  color: #2d2f31;
  background-color: #f2f2f2;
}

.dashboard-menu > a:hover {
  background-color: #df113c;
  color: #f2f2f2;
}

.dashboard-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 20px;
  padding: 0.5rem 1rem 1rem 1rem;
}

.dashboard-card {
  background-color: #f6f8fa;
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
  position: fixed;
  top: 0;
  right: 0;
  padding: 0.5rem 1.5rem;
  background-color: #f6f8fa;
  z-index: 3;
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
<script setup>
import { computed, ref, onMounted } from 'vue';

const orderedFoods = ref([]);

onMounted(() => {
  const getFoods = JSON.parse(localStorage.getItem('food'));
  if (getFoods) {
    orderedFoods.value = getFoods;
  }
});

const subtotal = computed(() =>
  orderedFoods.value.reduce((total, food) => total + food.price * food.count, 0)
);

const tax = computed(() => subtotal.value * 0.1);

const total = computed(() => {
  const deliveryFee = 5000;
  return subtotal.value + tax.value + deliveryFee;
});

function updateFoodCount(food, count) {
  const foodItem = orderedFoods.value.find((item) => item.foodtype === food.foodtype);
  if (foodItem) {
    foodItem.count = count;

    if (foodItem.count === 0) {
      orderedFoods.value = orderedFoods.value.filter((item) => item.foodtype !== food.foodtype);
    }
    
    localStorage.setItem('food', JSON.stringify(orderedFoods.value));
  }
}

function checkout() {
  alert('Order successfully checked out!');
  localStorage.removeItem('food');
  orderedFoods.value = [];
}
</script>


<template>    
<div class="dashboard-order">
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
  <div class="order-card" v-for="food in orderedFoods" :key="food.index">
      <img class="order-image" :src="food.pic">
      <div class="order-detail">
          <p>{{ food.foodtype }}</p>
          <i class="fas fa-times"></i>
            <input
              type="number"
              v-model.number="food.count"
              @change="updateFoodCount(food, food.count)"
            />
      </div>
      <h4 class="order-price">RP <span>{{ food.price }}</span></h4>
  </div>
</div>
      <hr class="divider">
<div class="order-total">
   <p>Subtotal <span>RP <span>{{ subtotal }}</span></span></p>
   <p>Tax (10%) <span>RP <span>{{ tax }}</span></span></p>
   <p>Delivery Fee <span>RP 5.000</span></p>

<div class="order-promo">
   <input class="input-promo" type="text" placeholder="Apply Voucer">
   <button class="button-promo">Find Promo</button>
</div>
     <hr class="divider">
     <p>Total <span>RP <span>{{ total }}</span></span></p>
</div>
      <button class="checkout" @click.prevent="checkout()">
              Checkout
      </button>
</div>
</div>
</template>

<style scoped>
.dashboard-order{
  margin-top: 5rem;
}
.dashboard-order {
  /* width: 340px; */
  min-height: 100%;
  /* position:fixed;
  top: 0;
  right: 0; */
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
</style>
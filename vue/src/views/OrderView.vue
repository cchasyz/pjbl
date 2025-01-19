<script setup>
import { computed, ref, onMounted } from 'vue';
import short from '@/router/axios';

const orderedFoods = ref([]);

onMounted(() => {
  const name = localStorage.getItem('name');
  const getFoods = JSON.parse(localStorage.getItem('food') || '[]');
  const getFoods2 = getFoods.filter((item)=>item.name === name);
  if (getFoods) {
    orderedFoods.value = getFoods2;
  }
});

const subtotal = computed(() =>
  orderedFoods.value.reduce((total, food) => total + food.price * food.count, 0)
);
const tax = computed(() => subtotal.value * 0.1);
const total = computed(() => {
  return subtotal.value + tax.value;
});
function updateFoodCount(food, count) {
  const foodItem = orderedFoods.value.find((item) => item.foodtype === food.foodtype);
  if (foodItem) {
    foodItem.count = count;
    if (foodItem.count <= 0) {
      orderedFoods.value = orderedFoods.value.filter((item) => item.foodtype !== food.foodtype);
    };
  }
  localStorage.setItem('food', JSON.stringify(orderedFoods.value));
}

async function checkout() {
  try {
    // Step 1: Get the snap token from the backend
    const res = await short.post('/create-transaction', {
      amount: total.value, 
    });
    const snapToken = res.data.snap_token;
    if (snapToken) {
      // Step 2: Trigger the Midtrans payment popup
      snap.pay(snapToken, {
        onSuccess: (result) => {
          console.log('Payment Success:', result);
          alert('Silahkan ambil pesanan anda sekitar 30 menit setelah pembelian');
          localStorage.removeItem('food');
          localStorage.removeItem('name');
          orderedFoods.value = [];
          window.location.href = '/';
        },
        onPending: (result) => {
          console.log('Payment Pending:', result);
          alert('Payment Pending. Please wait for the payment to be processed.');
        },
        onError: (result) => {
          console.error('Payment Error:', result);
          alert('Payment Failed. Try again.');
        },
      });
    } else {
      console.error('Failed to get Snap token');
      alert('Error generating Snap Token. Please try again.');
    }
  } catch (error) {
    console.error('Checkout Error:', error);
    alert('An error occurred during checkout. Please try again.');
  }
}
</script>


<template>    
<div class="dashboard-order">
  <h3>Order Menu</h3>
  <div class="order-address">
      <h4>PillarTasty Address</h4>
      <h4>Jl. Gunung Anyar Harapan ZA-25, Surabaya</h4>
  </div>
   <div class="order-time">
      <span class="fas fa-clock"></span> Estimasi matang : 30 mins 
   </div> 

   <div>
<div class="order-wrapper">
  <div class="order-card" v-for="food in orderedFoods" :key="food.index">
      <img :src="food.pic" class="order-image">
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
   <!-- <p>Delivery Fee <span>RP 5000</span></p> -->

<div class="order-promo">
   <input class="input-promo" type="text" placeholder="Apply Voucher">
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
  width: 50%;
  overflow-y:scroll;
  margin: 20px 0 0 25%;
  background: rgb(227, 227, 227);
}

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
  grid-template-columns: 0.2fr 0.1fr 0.09fr;
  align-items: center;
  justify-content: center;
  padding: 10px 0;
  gap: 5px;
}

.order-image {
  margin-left: 15%;
   width: 100px;
   height: 100px;
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
  width: 50%;
  padding: 0.5px;
  margin: 5px 0 10px 25%;
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
  font-weight: 600;
  background-color: #ae0026;
  transition: 300ms;
}

@media (max-width: 768px) {
  *{
    font-size: 107%;
  }
  .order-card{
    grid-template-columns: 0.4fr 0.2fr 0.1fr;
  }
  .order-promo {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #f2f2f2;
  border: 2px solid #d5d5d5;
  border-radius: 10px;
  height: 45px;
  width: 100%;
  padding: 0.5px;
  margin: 5px 0 10px 0;
}
.order-wrapper {
  height: 180px;
  width: 100%;
  overflow-y:scroll;
  margin: 20px 0;
  background: rgb(227, 227, 227);
}
}
</style>
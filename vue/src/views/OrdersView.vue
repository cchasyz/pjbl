<script setup>
import { ref, onMounted } from 'vue';
import short from '@/router/axios';

// Create a reactive variable for the orders
const orders = ref([]);

// Fetch the orders from your backend
const fetchOrders = async () => {
  try {
    const res = await short.get('/getOrders');
    // Assuming the orders are in res.data.data:
    orders.value = res.data.data;
    console.log("Fetched Orders:", orders.value);
  } catch (error) {
    console.error("Error fetching orders:", error);
  }
};

onMounted(() => {
  fetchOrders();
});
</script>

<template>
  <div class="orders-container">
    <h1>User Orders</h1>
    <div v-if="orders.length">
      <!-- Loop over each order -->
      <div v-for="order in orders" :key="order.id" class="order-card">
        <!-- Display user info from the nested order object -->
        <h2>User ID: {{ order.order.user_id }}</h2>
        <!-- Display the menu info -->
        <div class="menu-info">
          <img :src="order.menu.pic" alt="Menu image" class="menu-pic">
          <div class="menu-details">
            <p><strong>Name:</strong> {{ order.menu.name }}</p>
            <p><strong>Category:</strong> {{ order.menu.category }}</p>
            <p><strong>Price:</strong> Rp {{ order.menu.price }}</p>
          </div>
        </div>
        <!-- Additional order info -->
        <p><strong>Quantity:</strong> {{ order.quantity }}</p>
        <p><strong>Ordered At:</strong> {{ order.created_at }}</p>
      </div>
    </div>
    <div v-else>
      <p>No orders found.</p>
    </div>
  </div>
</template>

<style scoped>
.orders-container {
  margin-top: 5rem;
  padding: 1rem;
  background-color: #fff;
}
.order-card {
  border: 1px solid #ddd;
  padding: 1rem;
  margin-bottom: 1rem;
  border-radius: 4px;
}
.menu-info {
  display: flex;
  align-items: center;
  margin-bottom: 0.5rem;
}
.menu-pic {
  width: 100px;
  height: auto;
  margin-right: 1rem;
}
.menu-details p {
  margin: 0.2rem 0;
}
</style>

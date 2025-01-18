<template>
  <div>
    <h1>Make a Payment</h1>
    <input v-model="amount" type="number" placeholder="Enter amount" />
    <button @click="createPayment">Generate QRIS</button>

    <div v-if="qrCodeUrl">
      <h3>Scan this QR Code to Pay</h3>
      <img :src="qrCodeUrl" alt="QR Code" />
    </div>
  </div>
</template>

<script>
import short from '@/router/axios';

export default {
  data() {
    return {
      amount: '',
      qrCodeUrl: '',
    };
  },
  methods: {
    async createPayment() {
      if (!this.amount || this.amount <= 0) {
        alert('Please enter a valid amount');
        return;
        }
      try {
        const response = await short.post('/payments', { amount: this.amount });
        this.qrCodeUrl = response.data.qr_code_url;
      } catch (error) {
        console.error('Error creating payment:', error);
        alert('Failed to create payment');
      }
    },
  },
};
</script>

import './assets/main.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
// Import Feather Icons globally
import feather from 'feather-icons';

const app = createApp(App)
// Replace icons after the app mounts
app.use(router).mount('#app');

router.afterEach(() => {
  feather.replace();
});
import { createApp } from 'vue'
import { createPinia } from 'pinia'
// router
import router from './router'
// css
import './assets/css/reset.css'
import './assets/css/style.css'
// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
// icons
import 'boxicons/css/boxicons.min.css'
// app vue
import App from './App.vue'

const pinia = createPinia()
const app = createApp(App)

// use
app.use(router)
app.use(pinia)
app.mount('#app')
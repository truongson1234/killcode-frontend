import { createApp, markRaw } from 'vue'
import { createPinia } from 'pinia'
import router from './router'
import swal from 'sweetalert2';
window.Swal = swal;
import jQuery from 'jquery';
window.$ = jQuery

// css
import './assets/css/reset.css'
import './assets/css/style.css'

// bootstrap
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// icons
import 'boxicons/css/boxicons.min.css'

import './axios'
import './style.css'
import App from './App.vue'
const pinia = createPinia()
pinia.use(({ store }) => {
    store.router = markRaw(router)
})
const app = createApp(App)
app.use(pinia).use(router).mount('#app')

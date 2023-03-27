// import
import { createApp, markRaw } from 'vue';
import { createPinia } from 'pinia';
import CKEditor from '@ckeditor/ckeditor5-vue';
import router from './router';
import swal from 'sweetalert2';
import jQuery from 'jquery';
// component
import App from '@/App.vue';

// window
window.Swal = swal;
window.$ = jQuery;
window.jQuery = jQuery;

// bootstrap
// import 'bootstrap/dist/css/bootstrap.min.css';
// import 'bootstrap/dist/js/bootstrap.bundle.min.js';

// js
import '@/axios';

// link linh tinh
import 'boxicons/css/boxicons.min.css';

const pinia = createPinia();

pinia.use(({ store }) => {
    store.router = markRaw(router)
});

const app = createApp(App);

app.use(pinia);
app.use(router);
app.use(CKEditor)
app.mount('#app');

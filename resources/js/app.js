import Vue from 'vue';
import HttpService from 'axios';
import App from './views/App.vue';
import VueRouter from 'vue-router';
import routes from './routes.js';
import store from './data/store.js';
import LocalStorageService from './services/LocalStorageService';

HttpService.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (!token) {
    console.error('CSRF token not found');
}

HttpService.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
HttpService.defaults.headers.common['Accept'] = 'application/json';
HttpService.defaults.headers.common['Content-type'] = 'application/json';
HttpService.defaults.headers.common['Authorization'] = `Bearer ${LocalStorageService.getAuth()}`;

Vue.use(VueRouter);

const router = new VueRouter({
    mode: 'history',
    routes,
});

store.user = LocalStorageService.getUser();

const app = new Vue({
    router,
    data: store,
    components: {
        App,
    },
    template: `<App :hackathons="hackathons" :hackathon="hackathon" :idea="idea" :ideas="ideas" :user="user" :loginErrorMessage="loginErrorMessage" :breadcrumbs="breadcrumbs" />`,
}).$mount('#app');

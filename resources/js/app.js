import Vue from 'vue';
import HttpService from 'axios';
import App from './App.vue';
import VueRouter from 'vue-router';
import routes from './routes.js';
import store from './data/store.js';
import moment from "moment-timezone";
import VueMoment from 'vue-moment'
import LocalStorageService from './services/LocalStorageService';
import VueShowdown from 'vue-showdown'

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
Vue.use(VueMoment, {moment});

moment.tz.setDefault('UTC');

Vue.use(VueShowdown, {
    options: {
        emoji: true
    }
});

Vue.directive('focus', {
    // When the bound element is inserted into the DOM...
    inserted: function (el) {
        // Focus the element
        el.focus()
    }
})

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

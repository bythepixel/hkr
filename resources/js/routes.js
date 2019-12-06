import Hackathons from './views/Hackathons.vue';
import Hackathon from './views/Hackathon.vue';
import Idea from './views/Idea.vue';
import NewIdea from './views/NewIdea.vue';
import NewHackathon from './views/NewHackathon.vue';
import LoginView from './views/Login.vue';

import HttpService from 'axios';
import LocalStorageService from './services/LocalStorageService.js';

import store from './data/store.js';

import {
    HACKATHONS_VIEW_NAME,
    NEW_HACKATHON_VIEW_NAME,
    HACKATHON_VIEW_NAME,
    IDEA_VIEW_NAME,
    NEW_IDEA_VIEW_NAME,
    LOGIN_VIEW_NAME
} from './config/routes.js';

import {
    getHackathonsEndpoint
} from './config/endpoints.js';

let authInterceptor;

const attachInterceptor = (next) => {
    if (authInterceptor) {
        return;
    }

    authInterceptor = HttpService.interceptors.response.use(response => response, error => {
        if (error.response.status === 401) {
            store.loginErrorMessage = 'User is not authenticated';
            next({ name: LOGIN_VIEW_NAME, });
        }

        return Promise.reject(error);
    });
},
detachInterceptor = () => {
    if (!authInterceptor) {
        return;
    }

    HttpService.interceptors.response.eject(authInterceptor);
},
checkAuth = () => {
    return !!LocalStorageService.getAuth();
},
getHackathons = () => {
    HttpService.get(getHackathonsEndpoint()).then(response => {
        store.hackathons = response.data;
        return response.data;
    });
};

export default [
    {
        path: '/',
        name: HACKATHONS_VIEW_NAME,
        component: Hackathons,
        beforeEnter(to, from, next) {
            if (!checkAuth()) {
                next('/login');
            }
            attachInterceptor(next);
            next();
        }
    },
    {
        path: '/login',
        name: LOGIN_VIEW_NAME,
        component: LoginView,
        beforeEnter(to, from, next) {
            detachInterceptor();
            next();
        }
    },
    {
        path: '/new',
        name: NEW_HACKATHON_VIEW_NAME,
        component: NewHackathon,
        beforeEnter(to, from, next) {
            if (!checkAuth()) {
                next('/login');
            }

            if (!store.hackathons) {
                getHackathons();
            }

            attachInterceptor(next);
            next();
        }
    },
    {
        path: '/hackathon/:hackathonId',
        name:   HACKATHON_VIEW_NAME,
        component: Hackathon,
        beforeEnter(to, from, next) {
            if (!checkAuth()) {
                next('/login');
            }

            attachInterceptor(next);
            next();
        }
    },
    {
        path: '/hackathon/:hackathonId/ideas/new',
        name: NEW_IDEA_VIEW_NAME,
        component: NewIdea,
        beforeEnter(to, from, next) {
            if (!checkAuth()) {
                next('/login');
            }

            attachInterceptor(next);
            next();
        }
    },
    {
        path: '/hackathon/:hackathonId/ideas/:ideaId',
        name: IDEA_VIEW_NAME,
        component: Idea,
        beforeEnter(to, from, next) {
            if (!checkAuth()) {
                next('/login');
            }

            attachInterceptor(next);
            next();
        },
    },
];

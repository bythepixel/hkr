<template>
    <div v-if="loaded">
        <a class="user-control" v-if="user" v-on:click="logout()">Logout</a>
        <Breadcrumbs :hackathon="hackathon" :idea="idea" :breadcrumbs="breadcrumbs" />
        <router-view
            :hackathons="hackathons"
            :hackathon="hackathon"
            :idea="idea"
            :ideas="ideas"
            :user="user"
            :loginErrorMessage="loginErrorMessage">
        </router-view>
    </div>
</template>

<script>
    import Breadcrumbs from './Breadcrumbs.vue';
    import {logoutEndpoint} from "../config/endpoints";
    import HttpService from 'axios';
    import LocalStorageService from "../services/LocalStorageService";
    import store from '../data/store.js';

    export default {
        name: 'App',
        props: [
            'hackathons',
            'hackathon',
            'idea',
            'ideas',
            'user',
            'loginErrorMessage',
            'breadcrumbs'
        ],
	    data() {
		    return {
		    	loaded: false,
		    }
        },
        components: {
            Breadcrumbs,
        },
        created() {
            this.loaded = true;
        },
        methods: {
            logout() {
                HttpService.get(logoutEndpoint()).then(response => {
                    LocalStorageService.setUser(null);
                    LocalStorageService.setAuth(null);
                    store.user = null;
                    this.$router.push('login');
                });
            }
        }
    }
</script>

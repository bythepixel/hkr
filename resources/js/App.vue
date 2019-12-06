<template>
    <div v-if="loaded">
        <a class="user-control" v-if="user" v-on:click="logout()">Logout</a>
        <div class="container">
            <Breadcrumbs
                :hackathon="hackathon"
                :idea="idea"
                :breadcrumbs="breadcrumbs"
                @ideaTitleChanged="handleIdeaTitleEvent"
                :ideaTitle="ideaTitle"
            />
        </div>
        <router-view
            :hackathons="hackathons"
            :hackathon="hackathon"
            :idea="idea"
            :ideas="ideas"
            :user="user"
            :loginErrorMessage="loginErrorMessage"
            @ideaTitleChanged="handleIdeaTitleEvent"
            :ideaTitle="ideaTitle"
        />
    </div>
</template>

<script>
    import  Breadcrumbs from './components/Breadcrumbs.vue';
    import {logoutEndpoint} from "./config/endpoints";
    import HttpService from 'axios';
    import LocalStorageService from "./services/LocalStorageService";
    import store from './data/store.js';

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
                ideaTitle: null,
		    }
        },
        components: {
            Breadcrumbs,
        },
        created() {
            this.loaded = true;
        },
        methods: {
	        handleIdeaTitleEvent(ideaTitle) {
	            this.ideaTitle = ideaTitle;
            },
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

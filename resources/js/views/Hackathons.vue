<template>
    <div class="hackathons">
        <ul class="container">
            <li class="hackathons__item" v-for="hackathon in hackathons" :key="hackathon.id">
                <p class="hackathons__summary">
                    <router-link :to="{ name: hackathonRouteName, params: { hackathonId: hackathon.id } }" class="link">{{ hackathon.title }}</router-link>
                </p>
            </li>
        </ul>
        <div class="footer">
            <div class="container">
                <div class="footer__tools">
                    <router-link :to="{ name: newHackathonRouteName }" class="button">New Hackathon ""</router-link>
                </div>
                <Copyright/>
            </div>
        </div>
    </div>
</template>

<script>
import Copyright from '../components/Copyright';
import HttpService from 'axios';

import store from '../data/store.js';

import {
    NEW_HACKATHON_VIEW_NAME,
    HACKATHON_VIEW_NAME
} from '../config/routes.js';

import { getHackathonsEndpoint } from '../config/endpoints.js';

export default {
    name: "HackathonsView",
    props: ['hackathons'],
    components: {
    	Copyright,
    },
    data() {
        return {
            newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
            hackathonRouteName: HACKATHON_VIEW_NAME,
        }
    },
    created() {
        store.hackathon = null;
        store.idea = null;
        store.showCreateHackathonButton = true;
        this.getHackathons();
    },
    destroyed() {
        store.showCreateHackathonButton = false;
    },
    methods: {
        /**
         * @returns {Promise<AxiosResponse<any>>}
         */
        getHackathons() {
            HttpService.get(getHackathonsEndpoint()).then(response => store.hackathons = response.data);
        },
    }
}
</script>

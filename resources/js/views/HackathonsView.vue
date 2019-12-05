<template>
    <div id="hackathons">
        <div class="container">
            <ul class="hackathons-list">
                <li v-for="hackathon in hackathons" :key="hackathon.id">
                    <h2>
                        <router-link :to="{ name: hackathonRouteName, params: { hackathonId: hackathon.id } }">{{ hackathon.title }}</router-link>
                    </h2>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import HttpService from 'axios';

import store from '../data/store.js';

import {
    NEW_HACKATHON_VIEW_NAME,
    HACKATHON_VIEW_NAME
} from '../config/routes.js';

import {
    getHackathonsEndpoint,
    getHackathonEndpoint,
} from '../config/endpoints.js';

export default {
    name: "HackathonsView",
    props: ['hackathons'],
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

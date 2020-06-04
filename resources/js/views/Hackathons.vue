<template>
    <div class="hackathons">
        <div class="container">
            <div v-if="!loaded">{{ loaderText }}</div>
            <ul v-else class="hackathons__list">
                <li class="hackathons__item" v-for="hackathon in hackathons" :key="hackathon.id">
                    <p class="hackathons__summary">
                        <router-link :to="{ name: hackathonRouteName, params: { hackathonId: hackathon.id } }" class="link">{{ hackathon.title }}</router-link>
                    </p>
                </li>
            </ul>
        </div>
        <Footer>
            <router-link :to="{ name: newHackathonRouteName }" class="button">New Hackathon ""</router-link>
        </Footer>
    </div>
</template>

<script>
import Footer from '../components/Footer';
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
    	Footer,
    },
    data() {
        return {
            newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
            hackathonRouteName: HACKATHON_VIEW_NAME,
            loaded: false,
            loaderText: 'Loading hackathons...'
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
        getHackathons() {
            HttpService.get(getHackathonsEndpoint()).then(response => store.hackathons = response.data);
            this.loaded = true
        }
    }
}
</script>

<template>
    <div v-if="!!hackathon">
        <ul>
            <li v-if="hackathon.ideas && hackathon.ideas.length" v-for="idea in hackathon.ideas" v-on:click="setIdea(idea)" :key="idea.id">
                <IdeaVote :votes="idea.votes" />
                <router-link :to="{ name: ideaRouteName }">{{ idea.title }}</router-link>
            </li>
        </ul>
    </div>
</template>

<script>
    import store from '../data/store.js';

    import {
        NEW_IDEA_VIEW_NAME,
        IDEA_VIEW_NAME,
    } from '../config/routes.js';

    import IdeaVote from './IdeaVote.vue';

    import HttpService from 'axios';

    import { getHackathonEndpoint } from '../config/endpoints.js';

    export default {
        name: 'Hackathon',
        props: ['hackathon'],
        components: {
            IdeaVote,
        },
        data() {
            return {
                ideaRouteName: IDEA_VIEW_NAME,
                newIdeaRouteName: NEW_IDEA_VIEW_NAME,
            }
        },
        created() {
            store.showIdeaButton = true;
            HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId)).then(response => store.hackathon = response.data);
        },
        destroyed() {
            store.showIdeaButton = false;
        }
    }
</script>

<style scoped>

</style>

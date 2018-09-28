<template>
    <div v-if="!!hackathon">
        <div class="container">
            <ul>
                <li id="hackathon-details" v-if="hackathon.ideas && hackathon.ideas.length" v-for="idea in hackathon.ideas" v-on:click="setIdea(idea)" :key="idea.id">
                    <div class="vote-wrapper">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148"><defs></defs><path class="a" d="M0,0H56.148V56.148H0Z"/><path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/></svg>
                        <div class="vote-count">{{ idea.votes.length }}</div>
                        <IdeaVote :votes="idea.votes" />
                    </div>
                    <div class="content-wrapper">
                        <h2><router-link :to="{ name: ideaRouteName }">{{ idea.title }}</router-link></h2>
                        <p class="created-by">By {{ idea.user.name }}, {{ idea.messages.length }} Comments</p>
                        <p class="description">{{ idea.description }}</p>
                    </div>
                </li>
            </ul>
        </div>
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

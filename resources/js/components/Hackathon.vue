<template>
    <div v-if="!!hackathon">
        <div class="container">
            <ul>
                <li id="hackathon-details"
                    v-if="hackathon.ideas && hackathon.ideas.length"
                    v-for="idea in hackathon.ideas"
                    :key="idea.id">
                    <div class="vote-wrapper"
                         :class="{'voted': hasUserVoted(idea.votes)}"
                         v-on:click="handleVote(idea)">
                        <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 56.148 56.148">
                            <defs></defs>
                            <path class="a" d="M0,0H56.148V56.148H0Z"/>
                            <path class="b" d="M1,47.79h9.358V19.716H1ZM52.469,22.056a4.693,4.693,0,0,0-4.679-4.679H33.028L35.251,6.685l.07-.749a3.522,3.522,0,0,0-1.029-2.48L31.811,1,16.417,16.417a4.574,4.574,0,0,0-1.38,3.3v23.4a4.693,4.693,0,0,0,4.679,4.679H40.772a4.647,4.647,0,0,0,4.3-2.854l7.065-16.494a4.622,4.622,0,0,0,.328-1.708Z" transform="translate(1.34 1.34)"/>
                        </svg>
                        <div class="vote-count">{{ idea.votes.length }}</div>
                        <IdeaVote :votes="idea.votes" />
                    </div>
                    <div class="content-wrapper">
                        <h2><router-link :to="{ name: ideaRouteName, params: { ideaId: idea.id } }">{{ idea.title }}</router-link></h2>
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

    import SocketService from '../services/SocketService.js'

    import {
        NEW_IDEA_VIEW_NAME,
        IDEA_VIEW_NAME,
    } from '../config/routes.js';

    import IdeaVote from './IdeaVote.vue';

    import HttpService from 'axios';

    import { digestNewVotes } from '../data/digest.js';

    import { getHackathonEndpoint, getIdeaVotesEndpoint, addIdeaVoteEndpoint, deleteIdeaVoteEndpoint } from '../config/endpoints.js';

    export default {
        name: 'Hackathon',
        props: ['hackathon'],
        components: {
            IdeaVote,
        },
        data() {
            return {
                channel: null,
                ideaRouteName: IDEA_VIEW_NAME,
                newIdeaRouteName: NEW_IDEA_VIEW_NAME,
            }
        },
        created() {
            store.showIdeaButton = true;
            HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, "votes", "DESC")).then(response => {
                store.hackathon = response.data;
                this.subscribe(response.data.id);
            });
        },

        destroyed() {
            store.showIdeaButton = false;
        },
        methods: {
            subscribe(id) {
                this.channel = SocketService.subscribe(`hackathon.${id}`);
                this.channel.bind('App\\Events\\IdeaVoteAdded', (data) => {
                    HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
                });
                this.channel.bind('App\\Events\\IdeaVoteDeleted', (data) => {
                    HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
                });
            },
            handleVote(idea) {
                let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id });
                this.hasUserVoted(storeIdea.votes) ? this.deleteVote(storeIdea) : this.addVote(storeIdea);
            },
            deleteVote(idea) {
                idea.votes = idea.votes.filter((vote) => {
                    return vote.user_id !== store.user.id;
                });
                HttpService.delete(deleteIdeaVoteEndpoint(idea.id));
            },
            addVote(idea) {
                let vote = {
                    idea_id: idea.id,
                    user_id: store.user.id
                };
                idea.votes.push(vote);
                HttpService.post(addIdeaVoteEndpoint(), { idea_id: idea.id });
            },
            hasUserVoted(votes) {
                return !!votes.find(vote => { return vote.user_id === store.user.id });
            }
        }
    }
</script>

<style scoped>

</style>

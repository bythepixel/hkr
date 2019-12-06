<template>
    <div v-if="!!idea">
        <div class="idea">
            <IdeaVote :idea="idea" :hackathon="hackathon" />
            <div class="idea__content">
                <h2 class="idea__title">{{ idea.title }}</h2>
                <p class="idea__author">{{ idea.user.name }}, {{ idea.messages.length }} Comments</p>
                <p class="idea__description">{{ idea.description }}</p>
            </div>
        </div>
    </div>
</template>

<script>
	import store from '../data/store.js';
    import IdeaMessage from './IdeaMessage.vue';
    import IdeaVote from './IdeaVote.vue';

    import HttpService from 'axios';
    import SocketService from '../services/SocketService.js'
    import { getIdeaEndpoint, getHackathonEndpoint, addIdeaVoteEndpoint, deleteIdeaVoteEndpoint } from '../config/endpoints.js';

    export default {
	    name: "Idea",
	    components: {
		    IdeaMessage,
            IdeaVote,
	    },
	    data() {
		    return {
			    channel: null,
                idea: null,
                hackathon: null,
		    }
	    },
	    created() {
		    HttpService.get(getIdeaEndpoint(this.$route.params.ideaId)).then(response => {
			    this.idea = response.data;
			    this.subscribe(response.data.id);
			    this.sendIdeaTitle(response.data.title);
		    });

		    if(!store.hackathon) {
                HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, "votes", "DESC")).then(response => {
                    store.hackathon = response.data;
                });
            }
	    },
	    methods: {
            subscribe(id) {
                this.channel = SocketService.subscribe(`idea.${id}`);
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
            },
            sendIdeaTitle(ideaTitle) {
            	this.$emit('ideaTitle', ideaTitle);
            }
        },
        destroyed() {
	        this.ideaTitle = null;
        }
    }
</script>

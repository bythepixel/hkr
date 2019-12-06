<template>
    <div v-if="!!idea">
        <div class="idea-details container">
            <IdeaVote :idea="idea" :hackathon="hackathon" />
            <div class="idea-details__content">
                <h2 class="idea-details__title">{{ idea.title }}</h2>
                <p class="idea-details__author">{{ idea.user.name }}, {{ idea.messages.length }} Comments</p>
                <p class="idea-details__description">{{ idea.description }}</p>
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
		    });
		    if(!store.hackathon) {
                HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, "votes", "DESC")).then(response => {
                    store.hackathon = response.data;
                });
            }
	    },
	    methods: {
	    	// TODO: move these reusable functions into a component
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
        }
    }
</script>

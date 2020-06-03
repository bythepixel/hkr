<template>
    <div v-if="loaded" class="idea-view">
        <div class="container">
            <Idea
                :idea="idea"
                :hackathon="hackathon"
            />
        </div>
        <IdeaMessages :idea="idea" />
    </div>
</template>

<script>
    import Idea from '../components/Idea';
    import IdeaMessages from "../components/IdeaMessages";

    import HttpService from 'axios';
    import SocketService from '../services/SocketService.js'
    import { getIdeaEndpoint, getHackathonEndpoint, addIdeaVoteEndpoint, deleteIdeaVoteEndpoint } from '../config/endpoints.js';

    import store from '../data/store.js';

    export default {
        name: "IdeaView",
        props: ['ideaTitle'],
        components: {
            Idea,
            IdeaMessages
        },
	    data() {
		    return {
			    channel: null,
			    idea: null,
			    hackathon: null,
          loaded: false,
		    }
	    },
	    created() {
            this.loadIdea();
            this.loadHackathon();
	    },
	    methods: {
            bindEvents() {
                this.channel.unbind();
                this.channel.bind('App\\Events\\IdeaVoteAdded', (data) => {
	                this.loadIdea();
                });
                this.channel.bind('App\\Events\\IdeaVoteDeleted', (data) => {
	                this.loadIdea();
                });
                this.channel.bind('App\\Events\\IdeaMessageAdded', (data) => {
                	this.loadIdea();
                });
            },
            handleIdeaEvent(idea) {
                this.$emit('ideaRetrieved', idea);
            },
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
            loadIdea() {
                HttpService.get(getIdeaEndpoint(this.$route.params.ideaId)).then(response => {
                    this.idea = response.data;
                    this.loaded = true;
	                this.handleIdeaEvent(this.idea);
                    this.subscribe(response.data.id);
	                this.bindEvents();
                });
            },
            loadHackathon() {
	            if (!store.hackathon) {
		            HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, "most_recent", "unarchived")).then(response => {
			            store.hackathon = response.data;
		            });
	            }
            }
	    }
    }
</script>

<template>
    <div v-if="!!hackathon" class="hackathon container">
        <div class="hackathon__tools">
            <div class="sort">
                <select name="sortOrder" v-on:change="loadHackathon(true)" v-model.trim="sortOrder">
                    <option value="created_at">Created At</option>
                    <option value="title">Title</option>
                    <option value="votes">Votes</option>
                </select>
                <select name="sortDirection" v-on:change="loadHackathon(true)" v-model.trim="sortDirection">
                    <option value="DESC">DESC</option>
                    <option value="ASC">ASC</option>
                </select>
            </div>
            <router-link :to="{ name: newIdeaRouteName, params: { hackathonId: hackathon.id } }" class="button">Add an Idea</router-link>
            <div class="reset">
                <button role="button" v-on:click="reset()">Reset Votes</button>
            </div>
        </div>
        <div class="hackathon__loading" v-if="ideasLoading">loading ideas, some good, some bad...</div>
        <ul v-if="!ideasLoading">
            <li class="idea"
                v-if="hackathon.ideas && hackathon.ideas.length"
                v-for="idea in hackathon.ideas"
                :key="idea.id">
                <IdeaVote :idea="idea" :hackathon="hackathon" />
                <div class="idea__content">
                    <h2 class="idea__title">
                        <router-link :to="{ name: ideaRouteName, params: { ideaId: idea.id } }">{{ idea.title }}</router-link>
                    </h2>
                    <p class="idea__author">By {{ idea.user.name }} on {{ idea.created_at }}, {{ idea.messages.length }} Comments</p>
                    <p class="idea__description">
                        {{ idea.description }}
                    </p>
                    <div class="delete">
                        <a role="button" v-on:click="destroy(idea.id)">Delete</a>
                    </div>
                    <div class="archive" v-if="idea.archived === 0">
                        <a role="button" v-on:click="archive(idea.id)">Archive</a>
                    </div>
                    <div class="restore" v-if="idea.archived === 1">
                        <a role="button" v-on:click="restore(idea.id)">Restore</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>
	import store from '../data/store.js';

	import SocketService from '../services/SocketService.js'

	import {
		NEW_IDEA_VIEW_NAME,
		IDEA_VIEW_NAME,
	} from '../config/routes.js';

	import IdeaVote from '../components/IdeaVote.vue';

	import HttpService from 'axios';

	import { digestNewVotes } from '../data/digest.js';

	import { getHackathonEndpoint, getIdeaVotesEndpoint, deleteIdeaEndpoint, resetHackathonEndpoint } from '../config/endpoints.js';

	export default {
		name: 'IdeasView',
		props: ['hackathon'],
		components: {
			IdeaVote,
		},
		data() {
			return {
				channel: null,
				ideaRouteName: IDEA_VIEW_NAME,
				newIdeaRouteName: NEW_IDEA_VIEW_NAME,
				sortOrder: "created_at",
				sortDirection: "DESC",
                ideasLoading: true
			}
		},
		created() {
            this.channel = SocketService.subscribe(`hackathon.${this.$route.params.hackathonId}`);
			this.loadHackathon();
            this.bindEvents();
		},
		methods: {
			bindEvents() {
				this.channel.unbind();
				this.channel.bind('App\\Events\\IdeaVoteAdded', (data) => {
					HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
				});
				this.channel.bind('App\\Events\\IdeaVoteDeleted', (data) => {
					HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
				});
                this.channel.bind('App\\Events\\IdeaMessageAdded', (data) => {
                    this.loadHackathon();
                });
                this.channel.bind('App\\Events\\IdeaArchived', (data) => {
                    this.loadHackathon();
                });
                this.channel.bind('App\\Events\\IdeaRestored', (data) => {
                    this.loadHackathon();
                });
			},
            loadHackathon(showLoader) {
			    this.ideasLoading = showLoader;
                HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, this.sortOrder, this.sortDirection)).then(response => {
                    this.ideasLoading = false;
                    store.hackathon = response.data;
                });
            },
            reset() {
                if(confirm("Are you sure you want to delete all votes on this Hackathon?")) {
                    HttpService.get(resetHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
                        this.loadHackathon();
                    });
                }
            },
            destroy(id) {
                if (confirm("Are you sure you want to delete this idea, its votes and its comments?")) {
                    store.hackathon.ideas = store.hackathon.ideas.filter((idea) => {
                        return idea.id !== id;
                    });
                    HttpService.get(deleteIdeaEndpoint(id));
                }
            },
            archive(id) {},
            restore(id) {}
		}
	}
</script>

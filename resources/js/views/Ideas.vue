<template>
    <div v-if="!!hackathon" class="container">
        <div class="sort">
            <select name="sortOrder" v-on:change="order()" v-model.trim="sortOrder">
                <option value="created_at">Created At</option>
                <option value="title">Title</option>
                <option value="votes">Votes</option>
            </select>
            <select name="sortDirection" v-on:change="order()" v-model.trim="sortDirection">
                <option value="DESC">DESC</option>
                <option value="ASC">ASC</option>
            </select>
        </div>
        <div class="reset">
            <button role="button" v-on:click="reset()">Reset Votes</button>
        </div>
        <div class="ideas-loading" v-if="ideasLoading">loading ideas, some good, some bad...</div>
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
                    <p class="idea__author">By {{ idea.user.name }}, {{ idea.messages.length }} Comments</p>
                    <p class="idea__description">{{ idea.description }}</p>
                </div>
                <div class="delete">
                    <button role="button" v-on:click="destroy(idea.id)">Delete</button>
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

	import { getHackathonEndpoint, getIdeaVotesEndpoint } from '../config/endpoints.js';
    import {deleteIdeaEndpoint, resetHackathonEndpoint} from "../config/endpoints";

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
			store.showIdeaButton = true;
            this.ideasLoading = false;
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
				this.bindEvents();
			},
			bindEvents() {
				this.channel.unbind();
				this.channel.bind('App\\Events\\IdeaVoteAdded', (data) => {
					HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
				});
				this.channel.bind('App\\Events\\IdeaVoteDeleted', (data) => {
					HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(this.hackathon.ideas, data.idea_id, response.data));
				});
			},
			order() {
                this.ideasLoading = true;
				HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, this.sortOrder, this.sortDirection)).then(response => {
                    this.ideasLoading = false;
					store.hackathon = response.data;
					this.bindEvents();
				});
			},
            reset() {
                this.ideasLoading = true;
                if(confirm("Are you sure you want to delete all votes on this Hackathon?")) {
                    HttpService.get(resetHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
                        store.hackathon = response.data;
                        this.bindEvents();
                        this.ideasLoading = false;
                    });
                } else {
                    this.ideasLoading = false;
                    return false;
                }
            },
            destroy(id) {
              this.ideasLoading = true;
              if(confirm("Are you sure you want to delete this idea, its votes and its comments?")) {
                  HttpService.get(deleteIdeaEndpoint(id)).then(response => {
                      HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, this.sortOrder, this.sortDirection)).then(response => {
                          store.hackathon = response.data;
                          this.bindEvents();
                            this.ideasLoading = false;
                      });
                  });
              } else {
                  this.ideasLoading = false;
                  return false;
              }
            }
		}
	}
</script>

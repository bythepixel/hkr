<template>
    <div v-if="!!hackathon" class="hackathon container">
        <div class="hackathon__loading" v-if="ideasLoading">loading ideas, some good, some bad...</div>
        <ul v-if="!ideasLoading">
            <li class="idea"
                v-if="hackathon.ideas && hackathon.ideas.length"
                v-for="idea in hackathon.ideas"
                :key="idea.id">
                <div class="idea__inner">
                    <IdeaVote :idea="idea" :hackathon="hackathon" />
                    <div class="idea__content">
                        <h2 class="idea__title">
                            <router-link :to="{ name: ideaRouteName, params: { ideaId: idea.id } }" class="link"><span v-if="idea.archived === 1">ARCHIVED: </span>{{ idea.title }}</router-link>
                        </h2>
                        <p class="idea__details">
                            {{ idea.created_at }} | {{ idea.user.name }} | {{ idea.messages.length }} Comment<span v-if="idea.messages.length !== 1">s</span>
                        </p>
                        <p class="idea__description">
                            {{ idea.description }}
                        </p>
                        <a role="button" v-on:click="archive(idea.id)" v-if="idea.archived === 0" class="link link--reverse">Archive</a>
                        <a role="button" v-on:click="restore(idea.id)" v-if="idea.archived === 1" class="link link--reverse">Restore</a>
                        <a role="button" @click="destroy(idea.id)" class="link link--reverse">Delete</a>
                    </div>
                </div>
            </li>
        </ul>
        <div class="footer">
            <div class="container">
                <div class="footer__tools">
                    <div class="footer__buttons">
                        <router-link :to="{ name: newIdeaRouteName, params: { hackathonId: hackathon.id } }" class="button">
                            New Idea ""
                        </router-link>
                        <button role="button" @click="reset()" class="button">Reset Votes</button>
                        <button role="button" v-on:click="deleteHackathon()" class="button">Delete Hackathon</button>
                        <input type="checkbox" name="showArchives" id="showArchives" v-on:change="loadHackathon(true)" v-model.trim="showArchives" />
                        <label dor="showArchives">Show Archives</label>
                    </div>
                    <div class="footer__sort">
                        <select name="sortOrder" @change="loadHackathon(true)" v-model.trim="sortOrder">
                            <option value="created_at">Created At</option>
                            <option value="title">Title</option>
                            <option value="votes">Votes</option>
                        </select>
                        <select name="sortDirection" @change="loadHackathon(true)" v-model.trim="sortDirection">
                            <option value="DESC">Desc</option>
                            <option value="ASC">Asc</option>
                        </select>
                    </div>
                </div>
                <Copyright/>
            </div>
        </div>
    </div>
</template>

<script>
    import Copyright from '../components/Copyright';
	import store from '../data/store.js';

	import SocketService from '../services/SocketService.js'

	import {
		NEW_IDEA_VIEW_NAME,
		IDEA_VIEW_NAME,
	} from '../config/routes.js';

	import IdeaVote from '../components/IdeaVote.vue';

	import HttpService from 'axios';

	import { digestNewVotes } from '../data/digest.js';

	import { getHackathonEndpoint, getIdeaVotesEndpoint, deleteIdeaEndpoint, resetHackathonEndpoint, deleteHackathonEndpoint, archiveIdeaEndpoint, restoreIdeaEndpoint } from '../config/endpoints.js';

	export default {
		name: 'IdeasView',
		props: ['hackathon'],
		components: {
			IdeaVote,
            Copyright,
		},
		data() {
			return {
				channel: null,
				ideaRouteName: IDEA_VIEW_NAME,
				newIdeaRouteName: NEW_IDEA_VIEW_NAME,
				sortOrder: "created_at",
				sortDirection: "DESC",
                showArchives: false,
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
                HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, this.sortOrder, this.sortDirection, this.showArchives)).then(response => {
                    this.ideasLoading = false;
                    store.hackathon = response.data;
                });
            },
            resetHackathon() {
                if(confirm("Are you sure you want to delete all votes on this Hackathon?")) {
                    HttpService.get(resetHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
                        this.loadHackathon();
                    });
                }
            },
            deleteHackathon() {
                if(confirm("Are you sure you want to delete this Hackathon?")) {
                    HttpService.get(deleteHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
                        this.$router.push('/');
                    });
                }
            },
            destroy(id) {
                if (confirm("Are you sure you want to delete this idea, its votes and its comments?")) {
                    store.hackathon.ideas = store.hackathon.ideas.filter((idea) => {
                        return idea.id !== id;
                    });
                    HttpService.get(deleteIdeaEndpoint(id)).then(response => {
                      this.loadHackathon();
                    });;
                }
            },
            archive(id) {
              HttpService.get(archiveIdeaEndpoint(id));
            },
            restore(id) {
              HttpService.get(restoreIdeaEndpoint(id));
            }
		}
	}
</script>

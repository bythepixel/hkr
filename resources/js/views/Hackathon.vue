<template>
  <div class="container">
    <div v-if="!loaded">{{ loaderText }}</div>
    <div v-if="!!hackathon && loaded" class="hackathon">
      <ul>
        <li class="idea"
            v-if="hackathon.ideas && hackathon.ideas.length"
            v-for="idea in hackathon.ideas"
            :key="idea.id"
            :class="{'archived': idea.archived === 1}"
        >
          <div class="idea__inner">
            <IdeaVote :idea="idea" :hackathon="hackathon"/>
            <div class="idea__content">
              <h2 class="idea__title">
                <router-link :to="{ name: ideaRouteName, params: { ideaId: idea.id } }" class="link">{{ idea.title }}
                </router-link>
              </h2>
              <div class="idea__archived" v-if="idea.archived === 1">Archived</div>
              <p class="idea__details">
                {{ idea.created_at }} | {{ idea.user.name }} | {{ idea.messages.length }} Comment<span
                  v-if="idea.messages.length !== 1">s</span>
              </p>
              <p class="idea__description">
                {{ idea.description }}
              </p>
              <div class="idea__votes-favorites" v-if="votesVisible">
                <div class="idea__votes">
                  <p>Liked: <span v-if="idea.votes.length === 0">No likes yet!</span>
                    <span v-else
                       v-for="vote in idea.votes"
                       class="idea__interacted-user">{{ getUserNames(idea.votes.user_id) }}</span>
                  </p>
                </div>
                <div class="idea__favorites">
                  <p>Faved: <span v-if="idea.favorites.length === 0">No faves yet!</span>
                    <span v-else
                      v-for="favorite in idea.favorites"
                      class="idea__interacted-user">{{ favorite.user.name }}</span>
                  </p>
                </div>
              </div>
              <a role="button" @click="archiveIdea(idea.id)" v-if="idea.archived === 0" class="link link--underline">Archive</a>
              <a role="button" @click="restoreIdea(idea.id)" v-if="idea.archived === 1" class="link link--underline">Restore</a>
              <a role="button" @click="destroyIdea(idea.id)" class="link link--underline">Delete</a>
            </div>
          </div>
        </li>
        <li v-if="hackathon.ideas.length === 0">No ideas submitted yet :(</li>
      </ul>
      <Footer>
        <div class="footer__buttons">
          <router-link :to="{ name: newIdeaRouteName, params: { hackathonId: hackathon.id } }" class="button">
            New Idea ""
          </router-link>
        </div>
        <div class="footer__selects">
          <div class="field-wrapper">
            <label for="sort">Sort</label>
            <select id="sort" name="sort" @change="loadHackathon(true)" v-model.trim="sort">
              <option value="most_recent">Most Recent</option>
              <option value="most_voted">Most Voted</option>
              <option value="a_z">A-Z</option>
            </select>
          </div>
          <div class="field-wrapper">
            <label for="filter">Show</label>
            <select id="filter" name="filter" @change="loadHackathon(true)" v-model.trim="filter">
              <option value="unarchived">Unarchived</option>
              <option value="archived">Archived</option>
              <option value="all">All</option>
            </select>
          </div>
        </div>
        <div class="footer__links">
          <a role="button" @click="handleHackathonLock()" class="link link--underline"><span
              v-if="hackathon.locked">Un</span>lock</a>
          <a role="button" @click="handleVoteVisibility()" class="link link--underline"><span
              v-if="!votesVisible">Reveal</span><span v-else>Hide</span></a>
          <a role="button" @click="resetHackathon()" class="link link--underline">Reset</a>
          <router-link :to="{ name: newHackathonRouteName, params: { hackathonId: hackathon.id } }"
              class="link link--underline">Edit</router-link>
          <a role="button" @click="deleteHackathon()" class="link link--underline">Delete</a>
        </div>
      </Footer>
    </div>
  </div>
</template>

<script>
  import Footer from '../components/Footer'
  import IdeaVote from '../components/IdeaVote.vue'
  import store from '../data/store.js'

  import SocketService from '../services/SocketService.js'

  import {
    NEW_IDEA_VIEW_NAME,
    IDEA_VIEW_NAME,
    NEW_HACKATHON_VIEW_NAME,
  } from '../config/routes.js'

  import HttpService from 'axios'

  import {
    getHackathonEndpoint,
    deleteIdeaEndpoint,
    lockHackathonEndpoint,
    unlockHackathonEndpoint,
    resetHackathonEndpoint,
    deleteHackathonEndpoint,
    archiveIdeaEndpoint,
    restoreIdeaEndpoint
  } from '../config/endpoints.js'

  export default {
    name: 'IdeasView',
    props: ['hackathon'],
    components: {
      IdeaVote,
      Footer,
    },
    data () {
      return {
        channel: null,
        ideaRouteName: IDEA_VIEW_NAME,
        newIdeaRouteName: NEW_IDEA_VIEW_NAME,
        newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
        sort: 'most_recent',
        filter: 'unarchived',
        showArchives: false,
        loaded: false,
        votesVisible: false,
        loaderText: 'Loading ideas, some good, some bad...',
      }
    },
    created () {
      this.channel = SocketService.subscribe(`hackathon.${this.$route.params.hackathonId}`)
      this.loadHackathon()
      this.bindEvents()
    },
    methods: {
      bindEvents () {
        this.channel.unbind()
        this.channel.bind('App\\Events\\IdeaMessageAdded', (data) => {
          this.loadHackathon()
        })
        this.channel.bind('App\\Events\\IdeaArchived', (data) => {
          this.loadHackathon()
        })
        this.channel.bind('App\\Events\\IdeaRestored', (data) => {
          this.loadHackathon()
        })
        this.channel.bind('App\\Events\\HackathonLocked', (data) => {
          this.loadHackathon()
        })
        this.channel.bind('App\\Events\\HackathonUnlocked', (data) => {
          this.loadHackathon()
        })
      },
      handleVoteVisibility () {
        this.votesVisible = !this.votesVisible
      },
      loadHackathon () {
        HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, this.sort, this.filter)).then(response => {
          store.hackathon = response.data
          this.loaded = true
        })
      },
      resetHackathon () {
        if (confirm('Are you sure you want to delete all votes on this Hackathon?')) {
          HttpService.get(resetHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
            this.loadHackathon()
          })
        }
      },
      deleteHackathon () {
        if (confirm('Are you sure you want to delete this Hackathon?')) {
          HttpService.get(deleteHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
            this.$router.push('/')
          })
        }
      },
      handleHackathonLock () {
        if (!store.hackathon.locked) {
          HttpService.get(lockHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
            store.hackathon.locked = true
          })
        } else {
          HttpService.get(unlockHackathonEndpoint(this.$route.params.hackathonId)).then(response => {
            store.hackathon.locked = false
          })
        }
      },
      destroyIdea (id) {
        if (confirm('Are you sure you want to delete this idea, its votes and its comments?')) {
          store.hackathon.ideas = store.hackathon.ideas.filter((idea) => {
            return idea.id !== id
          })
          HttpService.get(deleteIdeaEndpoint(id)).then(response => {
            this.loadHackathon()
          })
        }
      },
      archiveIdea (id) {
        HttpService.get(archiveIdeaEndpoint(id))
      },
      restoreIdea (id) {
        HttpService.get(restoreIdeaEndpoint(id))
      },
    }
  }
</script>

<template>
  <div class="idea-view">
    <div class="container">
      <div v-if="!loaded">{{ loaderText }}</div>
      <div v-if="!!idea && loaded">
        <div class="idea">
          <div class="idea__inner">
            <IdeaVote v-if="hackathon && idea" :idea="idea" :hackathon="hackathon" @ideaRetrieved="handleIdeaChangeEvent"/>
            <div class="idea__content">
              <h2 class="idea__title">
                {{ idea.title }}
              </h2>
              <div class="idea__archived" v-if="idea.archived === 1">Archived</div>
              <p class="idea__details">
                {{ idea.created_at }} | {{ idea.user.name }} | {{ idea.messages.length }} Comment<span
                  v-if="idea.messages.length !== 1">s</span>
              </p>
              <p class="idea__description">
                {{ idea.description }}
              </p>
              <div v-if="idea.long_description" class="idea__long_description rendered-markdown">
                <VueShowdown :markdown="idea.long_description"/>
              </div>
            </div>
          </div>
        </div>
        <IdeaMessages :idea="idea" @ideaRetrieved="handleIdeaChangeEvent"/>
        <Footer>
          <div class="footer__buttons">
            <a role="button" @click="archiveIdea(idea.id)" v-if="idea.archived === 0" class="button">Archive</a>
            <a role="button" @click="restoreIdea(idea.id)" v-if="idea.archived === 1" class="button">Restore</a>
            <a role="button" @click="destroyIdea(idea.id)" class="button">Delete</a>
          </div>
        </Footer>
      </div>
    </div>
  </div>
</template>

<script>
  import Footer from '../components/Footer'
  import IdeaMessages from '../components/IdeaMessages'
  import IdeaVote from '../components/IdeaVote'

  import HttpService from 'axios'
  import SocketService from '../services/SocketService.js'
  import {
    getIdeaEndpoint,
    getHackathonEndpoint,
    archiveIdeaEndpoint,
    restoreIdeaEndpoint,
    deleteIdeaEndpoint,
  } from '../config/endpoints.js'

  import store from '../data/store.js'

  export default {
    name: 'IdeaView',
    props: ['ideaTitle'],
    components: {
      IdeaMessages,
      IdeaVote,
      Footer
    },
    data () {
      return {
        channel: null,
        loaded: false,
        hackathon: null,
        idea: null,
        loaderText: 'Loading idea...'
      }
    },
    created () {
      this.channel = SocketService.subscribe(`hackathon.${this.$route.params.hackathonId}`)
      this.loadHackathon()
      this.loadIdea()
    },
    destroyed() {
      this.loaded = false
    },
    methods: {
      bindEvents () {
        this.channel.unbind()
        this.channel.bind('App\\Events\\IdeaMessageAdded', (data) => {
          this.loadHackathon()
        })
      },
      handleIdeaEvent (idea) {
        this.$emit('ideaRetrieved', idea)
      },
      handleIdeaChangeEvent(idea) {
        this.idea = idea;
      },
      subscribe (id) {
        this.channel = SocketService.subscribe(`idea.${id}`)
      },
      loadIdea () {
        HttpService.get(getIdeaEndpoint(this.$route.params.ideaId)).then(response => {
          store.idea = this.idea = response.data
          this.handleIdeaEvent(store.idea)
          this.subscribe(response.data.id)
          this.bindEvents()
          this.loaded = true
        })
      },
      loadHackathon () {
        HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, 'most_recent', 'unarchived')).then(response => {
          store.hackathon = this.hackathon = response.data
        })
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
        this.setIdeaState()
        HttpService.get(archiveIdeaEndpoint(id))
      },
      restoreIdea (id) {
        this.setIdeaState()
        HttpService.get(restoreIdeaEndpoint(id))
      },
      setIdeaState() {
        this.idea.archived = this.idea.archived === 0 ? this.idea.archived = 1 : this.idea.archived = 0
      }
    }
  }
</script>

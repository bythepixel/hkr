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
        <IdeaMessages :idea="idea"/>
      </div>
    </div>
  </div>
</template>

<script>
  import IdeaMessages from '../components/IdeaMessages'
  import IdeaVote from '../components/IdeaVote'

  import HttpService from 'axios'
  import SocketService from '../services/SocketService.js'
  import {
    getIdeaEndpoint,
    getHackathonEndpoint,
  } from '../config/endpoints.js'

  import store from '../data/store.js'

  export default {
    name: 'IdeaView',
    props: ['ideaTitle'],
    components: {
      IdeaMessages,
      IdeaVote
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
      }
    }
  }
</script>

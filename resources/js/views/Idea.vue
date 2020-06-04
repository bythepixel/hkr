<template>
  <div v-if="loaded" class="idea-view">
    <div class="container">
      <div class="idea">
        <div class="idea__inner">
          <IdeaVote :idea="idea" :hackathon="hackathon"/>
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
          </div>
        </div>
      </div>
    </div>
    <IdeaMessages :idea="idea"/>
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
        idea: null,
        loaded: false,
        hackathon: null,
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
      subscribe (id) {
        this.channel = SocketService.subscribe(`idea.${id}`)
      },
      loadIdea () {
        HttpService.get(getIdeaEndpoint(this.$route.params.ideaId)).then(response => {
          store.idea = this.idea = response.data
          this.handleIdeaEvent(this.idea)
          this.subscribe(response.data.id)
          this.bindEvents()
          this.loaded = true
        })
        this.idea = store.idea
      },
      loadHackathon () {
        HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, 'most_recent', 'unarchived')).then(response => {
          store.hackathon = this.hackathon = response.data
        })
      }
    }
  }
</script>

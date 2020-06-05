<template>
  <div v-if="loaded" class="content-wrapper">
    <Header
        :hackathon="hackathon"
        :idea="idea"
        :breadcrumbs="breadcrumbs"
        @ideaRetrieved="handleIdeaEvent"
        :ideaTitle="idea ? idea.title : ''"
        :user="user"
        @userLogoutRetrieved="handleLogout"
    />
    <router-view
        :hackathons="hackathons"
        :hackathon="hackathon"
        :idea="idea"
        :ideas="ideas"
        :user="user"
        :loginErrorMessage="loginErrorMessage"
        @ideaRetrieved="handleIdeaEvent"
    />
  </div>
</template>

<script>
  import Header from './components/Header.vue'
  import { logoutEndpoint } from './config/endpoints'
  import HttpService from 'axios'
  import LocalStorageService from './services/LocalStorageService'
  import store from './data/store.js'

  export default {
    name: 'App',
    props: [
      'hackathons',
      'hackathon',
      'idea',
      'ideas',
      'user',
      'loginErrorMessage',
      'breadcrumbs'
    ],
    data () {
      return {
        loaded: false,
      }
    },
    components: {
      Header,
    },
    created () {
      this.loaded = true
    },
    methods: {
      handleIdeaEvent (idea) {
        store.idea = idea
      },
      handleLogout () {
        HttpService.get(logoutEndpoint()).then(response => {
          LocalStorageService.setUser(null)
          LocalStorageService.setAuth(null)
          store.user = null
          this.$router.go('/login')
        })
      }
    }
  }
</script>

<template>
  <div class="header">
    <div class="container">
      <div class="header__top">
        <ul class="header__breadcrumbs breadcrumbs">
          <li class="breadcrumbs__item">
            <router-link v-if="breadcrumbs.linkToIndex" :to="{ name: hackathonsRouteName }" class="link link--outline">
              {{ breadcrumbs.text }}
            </router-link>
            <span v-else>{{ breadcrumbs.text }}</span>
          </li>
          <li v-if="hackathon" class="breadcrumbs__item">
            <span v-if="!title">{{ hackathon.title }}</span>
            <router-link v-else :to="{ name: hackathonRouteName }" class="link link--underline">{{ hackathon.title }}
            </router-link>
          </li>
          <li v-if="title" class="breadcrumbs__item">
            <span>{{ title }}</span>
          </li>
        </ul>
        <div class="header__user" v-if="user">
          <p>
            <span class="header__user-name">
                User: <router-link :to="{ name: userRouteName }" class="link link--underline">{{ user.name }}</router-link>
            </span>
            <span class="header__user-logout">
                <a class="link link--underline" @click="handleUserLogout">Logout</a>
            </span>
          </p>
        </div>
      </div>
      <hr>
    </div>
  </div>
</template>

<script>
  import {
    HACKATHONS_VIEW_NAME,
    HACKATHON_VIEW_NAME,
    IDEA_VIEW_NAME,
    NEW_IDEA_VIEW_NAME,
    NEW_HACKATHON_VIEW_NAME,
    USER_VIEW_NAME,
  } from '../config/routes'

  export default {
    props: [
      'hackathon',
      'idea',
      'breadcrumbs',
      'user'
    ],
    name: 'Breadcrumbs',
    data () {
      return {
        hackathonsRouteName: HACKATHONS_VIEW_NAME,
        hackathonRouteName: HACKATHON_VIEW_NAME,
        ideaRouteName: IDEA_VIEW_NAME,
        newIdeaRouteName: NEW_IDEA_VIEW_NAME,
        newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
        userRouteName: USER_VIEW_NAME,
        title: '',
      }
    },
    created() {
      this.getPageTitle()
    },
    watch: {
      $route (to, from) {
        this.getPageTitle()
      },
      idea() {
        this.getPageTitle()
      }
    },
    methods: {
      handleUserLogout () {
        this.$emit('userLogoutRetrieved')
      },
      getPageTitle () {
        this.clearPageTitle()

        if (this.$route.name === this.ideaRouteName) {
          this.title = this.idea.title
        } else if (this.$route.name === this.newIdeaRouteName) {
          this.title = 'New Idea'
        } else if (this.$route.name === this.newHackathonRouteName) {
          this.title = 'New Hackathon'
        } else if (this.$route.name === this.userRouteName) {
          this.title = 'My Ideas'
        } else {
          this.clearPageTitle()
        }
      },
      clearPageTitle () {
        this.title = ''
      }
    }
  }
</script>

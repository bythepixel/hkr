<template>
  <div class="vote-favorite">
    <div class="vote-favorite__count-wrapper">
      <div class="vote-favorite__count">
        <span v-if="idea.votes">
            {{ idea.votes.length }} like<span v-if="idea.votes.length !== 1">s</span>
        </span>
        <span v-else>
            0 likes
        </span>
      </div>
      <div class="vote-favorite__count">
        <span v-if="idea.favorites">
            {{ idea.favorites.length }} fave<span v-if="idea.favorites.length !== 1">s</span>
        </span>
        <span v-else>
            0 faves
        </span>
      </div>
    </div>
    <div class="vote-favorite__link-wrapper" v-if="hackathon.locked === 0">
      <div
          class="vote-favorite__link link"
          :class="{'interacted': hasUserVoted(idea.votes)}"
          @click="handleVote(idea)"
      >Like
      </div>
      <div
          class="vote-favorite__link link"
          :class="{'interacted': hasUserFavorited(idea.favorites)}"
          @click="handleFavorite(idea)"
      >Fave
      </div>
    </div>
  </div>
</template>

<script>
  import store from '../data/store.js'
  import HttpService from 'axios'
  import { addIdeaVoteEndpoint, deleteIdeaVoteEndpoint, addIdeaFavoriteEndpoint, deleteIdeaFavoriteEndpoint } from '../config/endpoints.js'
  import { digestNewVotes, digestNewFavorites } from '../data/digest.js'
  import SocketService from '../services/SocketService.js'

  import {
    getIdeaVotesEndpoint,
    getIdeaFavoritesEndpoint
  } from '../config/endpoints.js'

  export default {
    name: 'IdeaVote',
    props: [
      'idea',
      'hackathon',
    ],
    created() {
      this.channel = SocketService.subscribe(`hackathon.${this.$route.params.hackathonId}`)
      this.bindEvents()
    },
    methods: {
      bindEvents () {
        this.channel.unbind()
        this.channel.bind('App\\Events\\IdeaVoteAdded', (data) => {
          HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(store.hackathon.ideas, data.idea_id, response.data))
        })
        this.channel.bind('App\\Events\\IdeaVoteDeleted', (data) => {
          HttpService.get(getIdeaVotesEndpoint(data.idea_id)).then(response => digestNewVotes(store.hackathon.ideas, data.idea_id, response.data))
        })
        this.channel.bind('App\\Events\\IdeaFavoriteAdded', (data) => {
          HttpService.get(getIdeaFavoritesEndpoint(data.idea_id)).then(response => digestNewFavorites(store.hackathon.ideas, data.idea_id, response.data))
        })
        this.channel.bind('App\\Events\\IdeaFavoriteDeleted', (data) => {
          HttpService.get(getIdeaFavoritesEndpoint(data.idea_id)).then(response => digestNewFavorites(store.hackathon.ideas, data.idea_id, response.data))
        })
      },
      handleVote (idea) {
        let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id })
        this.hasUserVoted(storeIdea.votes) ? this.deleteVote(storeIdea) : this.addVote(storeIdea)
      },
      deleteVote (idea) {
        idea.votes = idea.votes.filter((vote) => {
          return vote.user_id !== store.user.id
        })
        HttpService.delete(deleteIdeaVoteEndpoint(idea.id))
        this.emitIdea(idea)
      },
      addVote (idea) {
        let vote = {
          idea_id: idea.id,
          user_id: store.user.id,
          user_name: store.user.name,
        }
        idea.votes.push(vote)
        HttpService.post(addIdeaVoteEndpoint(), { idea_id: idea.id })
        this.emitIdea(idea)
      },
      hasUserVoted (votes) {
        return !!votes.find(vote => { return vote.user_id === store.user.id })
      },
      handleFavorite (idea) {
        let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id })
        this.hasUserFavorited(storeIdea.favorites) ? this.deleteFavorite(storeIdea) : this.addFavorite(storeIdea)
      },
      deleteFavorite (idea) {
        idea.favorites = idea.favorites.filter((favorite) => {
          return favorite.user_id !== store.user.id
        })
        HttpService.delete(deleteIdeaFavoriteEndpoint(idea.id))
        this.emitIdea(idea)
      },
      addFavorite (idea) {
        let unFavedIdea = null
        store.hackathon.ideas.forEach(function (idea, ideaIndex) {
          idea.favorites.forEach(function (favorite, favoriteIndex) {
            if (favorite.user_id === store.user.id) {
              unFavedIdea = store.hackathon.ideas[ideaIndex].favorites.splice(favoriteIndex, 1)
            }
          })
        })
        if (unFavedIdea === null || unFavedIdea[0].idea_id !== idea.id) {
          let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id })
          let favorite = {
            idea_id: storeIdea.id,
            user_id: store.user.id,
            user_name: store.user.name,
          }
          storeIdea.favorites.push(favorite)
          HttpService.post(addIdeaFavoriteEndpoint(), { idea_id: storeIdea.id, hackathon_id: store.hackathon.id })
        }
        this.emitIdea(idea)
      },
      hasUserFavorited (favorites) {
        return !!favorites.find(favorite => { return favorite.user_id === store.user.id })
      },
      emitIdea(idea) {
        this.$emit('ideaRetrieved', idea)
      },
    }
  }
</script>

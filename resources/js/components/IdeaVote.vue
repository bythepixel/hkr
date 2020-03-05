<template>
    <div class="vote-favorite">
        <div class="vote" :class="{'voted': hasUserVoted(idea.votes)}">
            <div class="vote__count">{{ idea.votes.length }} vote<span v-if="idea.votes.length !== 1">s</span></div>
            <div class="vote__link link" @click="handleVote(idea)">Vote</div>
        </div>
        <div class="favorite"
            :class="{'favorited': hasUserFavorited(idea.favorites)}"
            v-on:click="handleFavorite(idea)"
        >
            <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd">
                <path d="M15.668 8.626l8.332 1.159-6.065 5.874 1.48 8.341-7.416-3.997-7.416 3.997 1.481-8.341-6.064-5.874 8.331-1.159 3.668-7.626 3.669 7.626zm-6.67.925l-6.818.948 4.963 4.807-1.212 6.825 6.068-3.271 6.069 3.271-1.212-6.826 4.964-4.806-6.819-.948-3.002-6.241-3.001 6.241z"/>
            </svg>
            <div class="favorite__count">{{ idea.favorites.length }}</div>
        </div>
    </div>
</template>

<script>
	import store from '../data/store.js';
    import HttpService from 'axios';
	import { addIdeaVoteEndpoint, deleteIdeaVoteEndpoint, addIdeaFavoriteEndpoint } from '../config/endpoints.js';
    export default {
        name: 'IdeaVote',
        props: [
        	'idea',
            'hackathon'
        ],
        methods: {
            handleVote(idea) {
                let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id });
                this.hasUserVoted(storeIdea.votes) ? this.deleteVote(storeIdea) : this.addVote(storeIdea);
            },
            deleteVote(idea) {
                idea.votes = idea.votes.filter((vote) => {
                    return vote.user_id !== store.user.id;
                });
                HttpService.delete(deleteIdeaVoteEndpoint(idea.id));
            },
            addVote(idea) {
                let vote = {
                    idea_id: idea.id,
                    user_id: store.user.id
                };
                idea.votes.push(vote);
                HttpService.post(addIdeaVoteEndpoint(), { idea_id: idea.id });
            },
            hasUserVoted(votes) {
                return !!votes.find(vote => { return vote.user_id === store.user.id });
            },
            handleFavorite(idea) {
                store.hackathon.ideas.forEach(function(idea, ideaIndex){
                  idea.favorites.forEach(function(favorite, favoriteIndex) {
                    if(favorite.user_id === store.user.id) {
                      store.hackathon.ideas[ideaIndex].favorites.splice(favoriteIndex, 1);
                    }
                  });
                });
                let storeIdea = store.hackathon.ideas.find((innerIdea) => { return innerIdea.id === idea.id });
                let favorite = {
                  idea_id: storeIdea.id,
                  user_id: store.user.id
                };
                storeIdea.favorites.push(favorite);
                HttpService.post(addIdeaFavoriteEndpoint(), { idea_id: storeIdea.id, hackathon_id: store.hackathon.id });
            },
            hasUserFavorited(favorites) {
                return !!favorites.find(favorite => { return favorite.user_id === store.user.id });
            },
        }
    }
</script>

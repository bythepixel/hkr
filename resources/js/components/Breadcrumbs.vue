<template>
    <div class="header">
        <ul class="breadcrumbs">
            <li class="breadcrumbs__item">
                <router-link v-if="breadcrumbs.linkToIndex" :to="{ name: hackathonsRouteName }">{{ breadcrumbs.text }}</router-link>
                <span v-if="!breadcrumbs.linkToIndex">{{ breadcrumbs.text }}</span>
            </li>
            <li v-if="hackathon" class="breadcrumbs__item">
                <router-link v-if="isIdeaPage" :to="{ name: ideasRouteName }">{{ hackathon.title }}</router-link>
                <span v-if="!isIdeaPage">{{ hackathon.title }}</span>
            </li>
            <li v-if="isIdeaPage" class="breadcrumbs__item">
                <span>{{ ideaTitle }}</span>
            </li>
        </ul>
        <div v-if="showCreateHackathon">
            <router-link :to="{ name: newHackathonRouteName }" class="button">Create a Hackathon</router-link>
        </div>
        <div v-if="showAddAnIdea">
            <router-link :to="{ name: newIdeaRouteName, params: { hackathonId: hackathon.id } }" class="button">Add an Idea</router-link>
        </div>
    </div>
</template>

<script>
    import {
        HACKATHONS_VIEW_NAME,
        IDEAS_VIEW_NAME,
        IDEA_VIEW_NAME,
        NEW_IDEA_VIEW_NAME,
        NEW_HACKATHON_VIEW_NAME,
    } from '../config/routes';

    import store from '../data/store.js';

    export default {
        props: [
        	'hackathon',
            'idea',
            'breadcrumbs',
            'ideaTitle'
        ],
        name: 'Breadcrumbs',
        data() {
            return {
                hackathonsRouteName: HACKATHONS_VIEW_NAME,
	            ideasRouteName: IDEAS_VIEW_NAME,
                ideaRouteName: IDEA_VIEW_NAME,
                newIdeaRouteName: NEW_IDEA_VIEW_NAME,
                newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
            }
        },
        computed: {
            showCreateHackathon() {
                return store.showCreateHackathonButton;
            },
            showAddAnIdea() {
                return this.hackathon && store.showIdeaButton;
            },
	        isIdeaPage() {
		        return this.$route.name === this.ideaRouteName;
	        }
        }
    }
</script>

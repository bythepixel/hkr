<template>
    <div class="container">
        <div id="top-section">
            <ol class="breadcrumbs">
                <li class="breadcrumb-item">
                    <router-link v-if="breadcrumbs.linkToIndex" :to="{ name: hackathonsRouteName }">{{ breadcrumbs.text }}</router-link>
                    <span v-if="!breadcrumbs.linkToIndex">{{ breadcrumbs.text }}</span>
                </li>
                <li v-if="hackathon" class="breadcrumb-item">
                    <router-link v-if="idea" to="{ name: hackathonRouteName }">{{ hackathon.title }}</router-link>
                    <span v-if="!idea">{{ hackathon.title }}</span>
                </li>
                <li v-if="idea" class="breadcrumb-item">
                    <span>{{ idea.title }}</span>
                </li>
            </ol>
            <div v-if="showCreateHackathon">
                <router-link :to="{ name: newHackathonRouteName }" class="button">Create a Hackathon</router-link>
            </div>
            <div v-if="showAddAnIdea">
                <router-link :to="{ name: newIdeaRouteName, params: { hackathonId: hackathon.id } }" class="button">Add an Idea</router-link>
            </div>
        </div>
    </div>
</template>

<script>
    import {
        HACKATHONS_VIEW_NAME,
        HACKATHON_VIEW_NAME,
        IDEAS_VIEW_NAME,
        NEW_IDEA_VIEW_NAME,
        NEW_HACKATHON_VIEW_NAME,
    } from '../config/routes';

    import store from '../data/store.js';

    export default {
        props: ['hackathon', 'idea', 'breadcrumbs'],
        name: 'Breadcrumbs',
        data() {
            return {
                hackathonsRouteName: HACKATHONS_VIEW_NAME,
                hackathonRouteName: HACKATHON_VIEW_NAME,
                ideaRouteName: IDEAS_VIEW_NAME,
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
            }
        }
    }
</script>

<style scoped>
    li {
        font-family: "Comic Sans MS", cursive, sans-serif;
        font-size: 20px;
    }

    ul, li {
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        align-items: flex-start;
    }

    .container {
        padding-bottom: 0;
    }

    #top-section {
        margin-bottom: 0;
    }
</style>

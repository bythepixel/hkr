<template>
    <div class="container">
        <div id="top-section">
            <ol class="breadcrumbs">
                <li class="breadcrumb-item">
                    <router-link :to="{ name: hackathonsRouteName }">Hackathonizer</router-link>
                </li>
                <li v-if="hackathon" class="breadcrumb-item">
                    <router-link v-if="feature" to="{ name: hackathonRouteName }">{{ hackathon.title }}</router-link>
                    <span v-if="!feature">{{ hackathon.title }}</span>
                </li>
                <li v-if="idea" class="breadcrumb-item">
                    <router-link v-if="idea" to="{ name: ideaRouteName }">{{ idea.title }}</router-link>
                    <span v-if="!idea">{{ idea.title }}</span>
                </li>
                <li v-if="feature" class="breadcrumb-item">
                    <span>{{ feature.title }}</span>
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
        props: ['hackathon', 'idea', 'feature'],
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
</style>

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
        </div>
    </div>
</template>

<script>
    import {
        HACKATHONS_VIEW_NAME,
        HACKATHON_VIEW_NAME,
        IDEAS_VIEW_NAME,
    } from '../config/routes';

    export default {
        props: ['hackathon', 'idea', 'feature'],
        name: 'Breadcrumbs',
        data() {
            return {
                hackathonsRouteName: HACKATHONS_VIEW_NAME,
                hackathonRouteName: HACKATHON_VIEW_NAME,
                ideaRouteName: IDEAS_VIEW_NAME,
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

<template>
    <div class="header">
        <div class="container">
            <div class="header__top">
                <ul class="header__breadcrumbs breadcrumbs">
                    <li class="breadcrumbs__item">
                        <router-link v-if="breadcrumbs.linkToIndex" :to="{ name: hackathonsRouteName }" class="link">{{ breadcrumbs.text }}</router-link>
                        <span v-if="!breadcrumbs.linkToIndex">{{ breadcrumbs.text }}</span>
                    </li>
                    <li v-if="hackathon" class="breadcrumbs__item">
                        <span v-if="!isIdeaPage && !isIdeaAddPage">{{ hackathon.title }}</span>
                        <router-link v-if="isIdeaPage || isIdeaAddPage" :to="{ name: hackathonRouteName }" class="link">{{ hackathon.title }}</router-link>
                    </li>
                    <li v-if="isIdeaPage" class="breadcrumbs__item">
                        <span>{{ ideaTitle }}</span>
                    </li>
                    <li v-if="isIdeaAddPage" class="breadcrumbs__item">
                        <span>New Idea</span>
                    </li>
                    <li v-if="isHackathonAddPage" class="breadcrumbs__item">
                        <span>New Hackathon</span>
                    </li>
                </ul>
                <div class="header__user-logout" v-if="user">
                    <p>
                        <span class="header__user-name">User: {{ user.name }} </span><a class="link" @click="handleUserLogout">Logout</a>
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
    } from '../config/routes';

    import store from '../data/store.js';

    export default {
        props: [
        	'hackathon',
            'idea',
            'breadcrumbs',
            'ideaTitle',
            'user'
        ],
        name: 'Breadcrumbs',
        data() {
            return {
                hackathonsRouteName: HACKATHONS_VIEW_NAME,
	            hackathonRouteName: HACKATHON_VIEW_NAME,
                ideaRouteName: IDEA_VIEW_NAME,
                newIdeaRouteName: NEW_IDEA_VIEW_NAME,
                newHackathonRouteName: NEW_HACKATHON_VIEW_NAME,
            }
        },
        computed: {
            showAddAnIdea() {
                return this.hackathon && store.showIdeaButton;
            },
	        isIdeaPage() {
		        return this.$route.name === this.ideaRouteName;
	        },
            isIdeaAddPage() {
                return this.$route.name === this.newIdeaRouteName;
            },
            isHackathonAddPage() {
                return this.$route.name === this.newHackathonRouteName;
            }
        },
        methods: {
            handleUserLogout() {
	            this.$emit('userLogoutRetrieved');
            }
        }
    }
</script>

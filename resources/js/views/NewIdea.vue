<template>
    <div class="container">
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <form v-on:submit.prevent="onSubmit">
            <div class="field-wrapper">
                <input type="text" v-model.trim="title" id="title" required="" :class="{'has-value': title}">
                <label for="title">Title</label>
            </div>
            <div class="field-wrapper">
                <textarea rows="4" cols="50" v-model.trim="description" id="description" required="" :class="{'has-value': description}"></textarea>
                <label for="description">Description</label>
            </div>
            <button role="button">Add</button>
        </form>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { newIdeaEndpoint } from '../config/endpoints';

	import { IDEAS_VIEW_NAME } from '../config/routes.js';

	import store from '../data/store.js';

	export default {
		name: "NewIdeaView",
		props: [],
		data() {
			return {
				errorMessage: null,
				title: null,
				description: null,
			}
		},
		created() {
			store.breadcrumbs.text = 'Hackathon Idea';
			store.breadcrumbs.linkToIndex = false;
			store.idea = null;
		},
		destroyed() {
			store.breadcrumbs.text = 'Hackathonizer';
			store.breadcrumbs.linkToIndex = true;
		},
		methods: {
			onSubmit(event) {
				this.errorMessage = null;

				if (!this.title) {
					this.errorMessage = 'Title is required';
					return;
				}

				HttpService.post(newIdeaEndpoint(), {
					title: this.title,
					description: this.description,
					hackathon_id: this.$route.params.hackathonId,
				}).then(response => {
					this.title = null;
					this.description = null;
					this.$router.push({ name: IDEAS_VIEW_NAME, params: { hackathonId: this.$route.params.hackathonId}});
				});
			},
			exit(event) {
				this.title = null;
				this.description = null;
				this.$router.push({ name: IDEAS_VIEW_NAME });
			}
		}

	}
</script>

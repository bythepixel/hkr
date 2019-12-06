<template>
    <div class="container">
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <form v-on:submit.prevent="onSubmit">
            <div class="field-wrapper">
                <input type="text" v-model.trim="title" id="title" required="" :class="{'has-value': title}">
                <label for="title">Name of Hackathon</label>
            </div>
            <button role="button">Create</button>
        </form>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { newHackathonEndpoint } from '../config/endpoints';

	import { HACKATHON_VIEW_NAME, HACKATHONS_VIEW_NAME } from '../config/routes.js';

	import store from '../data/store.js';

	export default {
		name: "NewHackathonView",
		props: ['user'],
		data() {
			return {
				errorMessage: null,
				title: null,
			}
		},
		created() {
			store.breadcrumbs.text = 'Create a Hackathon';
			store.breadcrumbs.linkToIndex = false;
			store.idea = null;
		},
		destroyed() {
			store.breadcrumbs.text = 'Hackatonizer';
			store.breadcrumbs.linkToIndex = true;
		},
		methods: {
			onSubmit(event) {
				this.errorMessage = null;

				if (!this.title) {
					this.errorMessage = 'Title is required';
					return;
				}

				HttpService.post(newHackathonEndpoint(), {
					user_id: this.user.id,
					title: this.title,
				}).then(response => {
					const id = response.data.id;

					store.hackathons.push({
						id,
						title: this.title,
						user_id: this.user.id,
						ideas: [],
					});

					this.title = null;

					this.$router.push({ name: HACKATHON_VIEW_NAME, params: { hackathonId: id }});
				});
			},
			exit(event) {
				this.title = null;
				this.$router.push({ name: HACKATHONS_VIEW_NAME });
			}
		}

	}
</script>

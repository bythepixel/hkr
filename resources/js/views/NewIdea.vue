<template>
    <div>
        <div class="container">
            <p v-if="errorMessage">{{ errorMessage }}</p>
            <form id="new-idea" @submit.prevent="onSubmit()">
                <div class="field-wrapper">
                    <label for="title">Title</label>
                    <input type="text" v-model.trim="title" id="title" required="" :class="{'has-value': title}" v-focus>
                </div>
                <div class="field-wrapper">
                    <label for="description">Short Description</label>
                    <textarea rows="4" cols="50" v-model.trim="description" id="description" required="" :class="{'has-value': description}"></textarea>
                </div>
                <div class="field-wrapper">
                    <label for="long_description">Long Description</label>
                    <textarea rows="4" cols="50" v-model.trim="long_description" id="long_description" :class="{'has-value': long_description}"></textarea>
                </div>
            </form>
        </div>
        <Footer>
            <button role="button" form="new-idea">Add</button>
        </Footer>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { newIdeaEndpoint, getHackathonEndpoint } from '../config/endpoints';

	import { HACKATHON_VIEW_NAME } from '../config/routes.js';

	import store from '../data/store.js';

    import Footer from '../components/Footer';

	export default {
		name: "NewIdeaView",
		props: [],
        components: {
            Footer,
        },
		data() {
			return {
				errorMessage: null,
				title: null,
				description: null,
                long_description: null,
                hackathon: null,
			}
		},
		created() {
			store.idea = null;
            this.loadHackathon();
		},
		methods: {
            loadHackathon() {
                if (!store.hackathon) {
                        HttpService.get(getHackathonEndpoint(this.$route.params.hackathonId, "most_recent", "unarchived")).then(response => {
                        store.hackathon = response.data;
                    });
                }
            },
			onSubmit() {
				this.errorMessage = null;

				if (!this.title) {
					this.errorMessage = 'Title is required';
					return;
				}

				HttpService.post(newIdeaEndpoint(), {
					title: this.title,
					description: this.description,
                    long_description: this.long_description,
					hackathon_id: this.$route.params.hackathonId,
				}).then(response => {
					this.title = null;
					this.description = null;
                    this.long_description = null;
					this.$router.push({ name: HACKATHON_VIEW_NAME, params: { hackathonId: this.$route.params.hackathonId}});
				});
			},
			exit(event) {
				this.title = null;
				this.description = null;
                this.long_description = null;
				this.$router.push({ name: HACKATHON_VIEW_NAME });
			}
		}

	}
</script>

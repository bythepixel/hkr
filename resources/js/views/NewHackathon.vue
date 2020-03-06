<template>
    <div>
        <div class="container">
            <p v-if="errorMessage">{{ errorMessage }}</p>
            <form id="new-hackathon" @submit.prevent="onSubmit()">
                <div class="field-wrapper">
                    <label for="title">Name of Hackathon</label>
                    <input type="text" v-model.trim="title" id="title" required="" :class="{'has-value': title}">
                </div>
            </form>
        </div>
        <Footer>
            <button role="button" form="new-hackathon">
                <span v-if="!editMode">
                    Create
                </span>
                <span v-else>
                    Update
                </span>
            </button>
        </Footer>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { newHackathonEndpoint, getHackathonEndpoint } from '../config/endpoints';

	import { HACKATHON_VIEW_NAME, HACKATHONS_VIEW_NAME } from '../config/routes.js';

	import store from '../data/store.js';

    import Footer from '../components/Footer';

	export default {
		name: "NewHackathonView",
		props: ['user'],
        components: {
            Footer,
        },
		data() {
			return {
				errorMessage: null,
				title: null,
                editMode: false,
			}
		},
		created() {
			store.idea = null;
			// TODO: Get this to work on refresh
			if (this.$route.params.hackathonId || store.hackathon) {
			  this.editMode = true;
              this.activateEditMode();
            }
        },
		methods: {
            activateEditMode() {
              this.loadHackathon();
            },
            loadHackathon() {
                const hackathonId = this.$route.params.hackathonId ? this.$route.params.hackathonId : store.hackathon.id;
                HttpService.get(getHackathonEndpoint(hackathonId, "votes", "DESC")).then(response => {
                    store.hackathon = response.data;
                    this.title = response.data.title;
                });
            },
			onSubmit() {
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

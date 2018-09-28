<template>
    <div id="create">
        <div class="container">
        <h1>Create a Hackathon</h1>
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <form v-on:submit.prevent="onSubmit">
            <div class="field-wrapper">
                <input type="text" v-model.trim="title" id="title" required="">
                <label for="title">Name of Hackathon</label>
            </div>
            <button role="button">Create</button>
        </form>
        </div>
    </div>
</template>

<script>
    import HttpService from 'axios';

    import { newHackathonEndpoint } from '../config/endpoints';

    import { HACKATHON_VIEW_NAME } from '../config/routes.js';

    import store from '../data/store.js';

    export default {
        name: "NewHackathonForm",
        data() {
            return {
                errorMessage: null,
                title: null,
            }
        },
        created() {
            store.showBreadcrumbs = false;
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
                    const id = response.id;

                    store.hackathons.push({
                        id,
                        title: this.title,
                        user_id: this.user.id,
                        ideas: [],
                    });

                    this.title = null;

                    this.$router.push({ name: HACKATHON_VIEW_NAME, params: { hackathonId: id }});
                });
            }
        }

    }
</script>

<style scoped>

</style>

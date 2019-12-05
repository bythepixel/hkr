<template>
    <div id="hackathon-idea-add">
        <div class="container">
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <form v-on:submit.prevent="onSubmit">
            <div class="field-wrapper">
                <input type="text" v-model.trim="title" id="title" required="">
                <label for="title">Title</label>
            </div>
            <div class="field-wrapper">
                <textarea rows="4" cols="50" v-model.trim="description" id="description" required=""></textarea>
                <label for="description">Description</label>
            </div>
            <div class="flex">
                <button role="button">Add</button>
            </div>
        </form>
        </div>
    </div>
</template>

<script>
    import HttpService from 'axios';

    import { newIdeaEndpoint } from '../config/endpoints';

    import { NEW_IDEA_VIEW_NAME, IDEAS_VIEW_NAME, HACKATHON_VIEW_NAME } from '../config/routes.js';

    import store from '../data/store.js';

    export default {
        name: "NewIdeaForm",
        props: ['user', 'hackathon'],
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
                    user_id: this.user.id,
                    title: this.title,
                    description: this.description,
                    hackathon_id: this.hackathon.id,
                }).then(response => {
                    const id = response.data.id;

                    store.hackathon.ideas.push({
                        id,
                        title: this.title,
                        description: this.description,
                        user_id: this.user.id,
                    });

                    this.title = null;
                    this.description = null;

                    this.$router.push({ name: HACKATHON_VIEW_NAME, params: { hackathonId: this.hackathon.id}});
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

<style scoped>
    .inverse-button {
        color: #000;
        background: #fff;
        box-shadow: 0 3px 15px rgba(0, 0, 0, 0.35), inset 0px 0px 0px 2px #000;
    }

    .inverse-button:hover {
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.35), inset 0px 0px 0px 2px #000;
    }
</style>

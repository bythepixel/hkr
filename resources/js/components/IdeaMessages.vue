<template>
    <div class="messages">
        <div class="container">
            <div class="messages__submit">
                <div class="field-wrapper">
                    <p v-if="errorMessage">{{ errorMessage }}</p>
                    <form v-on:submit.prevent="onSubmit">
                        <input type="text" name="comment" required="" v-model.trim="messageContent" :class="{'has-value': message}">
                        <label>Join the conversation...</label>
                    </form>
                </div>
                <p class="messages__enter-text small-text">Press "Enter" to Add</p>
            </div>
            <ul class="messages__message message">
                <li
                    v-if="ideaMessages"
                    v-for="message in ideaMessages"
                    :key="message.id"
                    class="message__item"
                >
                    <p class="message__name">{{ message.user.name }} <span class="small-text">{{ message.created_at}}</span></p>
                    <p class="message__content">{{ message.content }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { newIdeaEndpoint } from '../config/endpoints';

	import { HACKATHON_VIEW_NAME } from '../config/routes.js';

	import store from '../data/store.js';

    export default {
        name: "IdeaMessage",
        props: ['ideaMessages'],
        data() {
        	return {
                messageContent: "",
                errorMessage: null
            }
        },
	    methods: {
            onSubmit(event) {
                this.errorMessage = null;

                if (!this.messageContent) {
                    this.errorMessage = 'Message is required';
                    return;
                }
            }
        }
    }
</script>

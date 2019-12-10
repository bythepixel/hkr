<template>
    <div class="messages">
        <div class="container">
            <div class="messages__submit">
                <div class="field-wrapper">
                    <p v-if="errorMessage">{{ errorMessage }}</p>
                    <form v-on:submit.prevent="onSubmit">
                        <input
                            type="text"
                            name="comment"
                            required
                            maxlength="255"
                            v-model.trim="messageContent"
                            :class="{'has-value': messageContent}"
                        >
                        <label>Join the conversation...</label>
                    </form>
                </div>
                <p class="messages__enter-text small-text">Press "Enter" to Add</p>
            </div>
            <ul class="messages__message message">
                <li
                    v-if="idea.messages"
                    v-for="message in idea.messages"
                    :key="message.id"
                    class="message__item"
                >
                    <p class="message__name">{{ message.user.name }} <span class="small-text">{{ message.created_at | moment("timezone", "America/Denver") | moment("from", "now") }}</span>
                    </p>
                    <p class="message__content">{{ message.content }}</p>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
	import HttpService from 'axios';

	import { addIdeaMessageEndpoint } from '../config/endpoints';

	import store from '../data/store.js';

    export default {
        name: "IdeaMessage",
        props: [
        	'idea',
        ],
        data() {
        	return {
                messageContent: null,
                errorMessage: null
            }
        },
	    methods: {
            onSubmit() {
                this.errorMessage = null;

                if (!this.messageContent) {
                    this.errorMessage = 'Message is required';
                    return;
                }

	            HttpService.post(addIdeaMessageEndpoint(), {
	            	idea_id: this.idea.id,
		            content: this.messageContent,
	            }).then(response => {
                    const id = response.data.id;
                    const date = response.data.created_at;

		            store.idea.messages.push({
                        id,
                        created_at: date,
			            content: this.messageContent,
			            user: {
                        	name: store.user.name
                        }
		            });

		            this.messageContent = null;
	            });
            }
        }
    }
</script>

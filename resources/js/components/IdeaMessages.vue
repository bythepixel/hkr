<template>
  <div class="messages">
    <div class="container">
      <div class="messages__submit">
        <div class="field-wrapper">
          <p v-if="errorMessage">{{ errorMessage }}</p>
          <form @submit.prevent="onSubmit">
            <label>{{ user.name }}</label>
            <textarea
                type="text"
                name="comment"
                required
                maxlength="255"
                v-model.trim="messageContent"
                :class="{'has-value': messageContent}"
                v-focus
            />
          </form>
        </div>
      </div>
      <ul class="messages__message message">
        <li
            v-if="idea.messages"
            v-for="message in idea.messages"
            :key="message.id"
            class="message__item"
        >
          <span class="message__name">{{ message.user.name }}</span>
          <span class="message__time">({{ message.created_at | moment('timezone', 'America/Denver') | moment('from', 'now') }})</span>:
          <span class="message__content">{{ message.content }}</span>
        </li>
        <li v-if="!idea.messages.length">No messages yet</li>
      </ul>
    </div>
  </div>
</template>

<script>
  import HttpService from 'axios'

  import { addIdeaMessageEndpoint } from '../config/endpoints'

  import store from '../data/store.js'

  export default {
    name: 'IdeaMessage',
    props: [
      'idea',
    ],
    data () {
      return {
        messageContent: null,
        errorMessage: null,
        user: null
      }
    },
    created() {
      this.user = store.user
    },
    methods: {
      onSubmit () {
        this.errorMessage = null

        if (!this.messageContent) {
          this.errorMessage = 'Message is required'
          return
        }

        HttpService.post(addIdeaMessageEndpoint(), {
          idea_id: this.idea.id,
          content: this.messageContent,
        }).then(response => {
          const id = response.data.id
          const date = response.data.created_at

          store.idea.messages.push({
            id,
            created_at: date,
            content: this.messageContent,
            user: {
              name: store.user.name
            }
          })
          this.messageContent = null
          this.emitIdea(store.idea)
        })
      },
    },
    emitIdea(idea) {
      this.$emit('ideaRetrieved', idea)
    },
  }
</script>

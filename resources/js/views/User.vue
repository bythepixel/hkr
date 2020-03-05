<template>
    <div class="hackathon container">
        <h1>My Ideas</h1>
        <ul>
            <li class="idea"
                v-if="ideas && ideas.length"
                v-for="idea in ideas"
                :key="idea.id">
                <div class="idea__inner">
                    <div class="idea__content">
                        <h2 class="idea__title">
                            {{ idea.title }} - {{ idea.hackathon.title }}
                        </h2>
                        <p class="idea__details">
                            {{ idea.created_at | moment("timezone", "America/Denver") | moment("from", "now") }}
                        </p>
                        <p class="idea__description">
                            {{ idea.description }}
                        </p>
                        <p class="idea__long-description">
                            {{ idea.long_description }}
                        </p>
                        <label>Copy to Another Hackathon</label>
                        <select name="copy" v-model.trim="idea.copyHackathonId">
                            <option value="">Select a Hackathon</option>
                            <option v-for="hackathon in hackathons" :key="hackathon.id" :value="hackathon.id">{{ hackathon.title }}</option>
                        </select>
                        <a href="#" @click="copyIdea(idea)">Copy Idea</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<script>

  import HttpService from 'axios';

  import { copyIdeaEndpoint, getUserEndpoint } from '../config/endpoints.js';

  export default {
      name: 'UserView',
      props: [],
      data() {
          return {
              channel: null,
              ideas: null,
              hackathons: null,
              copyHackathonId: null
          }
      },
      created() {
          this.loadUserData();
      },
      methods: {
          loadUserData() {
              HttpService.get(getUserEndpoint()).then(response => {
                  this.ideas = response.data.ideas;
                  this.hackathons = response.data.hackathons;
              });
          },
          copyIdea(idea) {
              HttpService.post(copyIdeaEndpoint(), {
                  idea_id: idea.id,
                  hackathon_id: idea.copyHackathonId,
              }).then(response => {
                  this.loadUserData();
              });
          },
      }
  }
</script>

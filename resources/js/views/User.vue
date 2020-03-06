<template>
    <div class="user">
        <div class="container">
            <ul>
                <li class="idea"
                    v-if="ideas && ideas.length"
                    v-for="idea in ideas"
                    :key="idea.id">
                    <div class="idea__inner">
                        <div class="idea__content">
                            <h2 class="idea__title">
                                <router-link :to="{ name: ideaRouteName, params: { ideaId: idea.id } }" class="link">{{ idea.title }}</router-link>
                            </h2>
                            <div class="idea__archived" v-if="idea.archived === 1">Archived</div>
                            <p class="idea__details">
                                {{ idea.created_at }} | {{ idea.hackathon.title }}
                            </p>
                            <p class="idea__description">
                                {{ idea.description }}
                            </p>
                            <div class="idea__copy">
                                <div class="field-wrapper">
                                    <label>Copy to</label>
                                    <select name="copy" v-model.trim="idea.copyHackathonId">
                                        <option value="">Select a Hackathon</option>
                                        <option v-for="hackathon in hackathons" :key="hackathon.id" :value="hackathon.id">
                                            {{ hackathon.title }}
                                        </option>
                                    </select>
                                </div>
                                <a href="#" @click="copyIdea(idea)" class="link link--underline">Copy</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
        <Footer/>
    </div>
</template>

<script>

  import {
    IDEA_VIEW_NAME
  } from '../config/routes';

  import HttpService from 'axios';

  import {copyIdeaEndpoint, getUserEndpoint} from '../config/endpoints.js';

  import Footer from '../components/Footer';

  export default {
    name: 'UserView',
    components: {
      Footer,
    },
    props: [],
    data() {
      return {
        ideaRouteName: IDEA_VIEW_NAME,
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

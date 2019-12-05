<template>
    <div v-if="!!idea">
        <div class="container">
            <div class="messages">
                <div>
                    <div id="idea-details">
                        <h1>{{ idea.title }}</h1>

                    </div>
                </div>
                <div v-for="message in idea.messages" :key="message.id">
                    <IdeaMessage :message="message" />
                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import store from '../data/store.js';
    import IdeaMessage from './IdeaMessage.vue';

    import HttpService from 'axios';

    import SocketService from '../services/SocketService.js'

    import { getIdeaEndpoint } from '../config/endpoints.js';


    export default {
	    name: "Idea",
	    props: ['idea'],
	    components: {
		    IdeaMessage,
	    },
	    data() {
		    return {
			    channel: null,
		    }
	    },
	    created() {
		    HttpService.get(getIdeaEndpoint(this.$route.params.ideaId)).then(response => {
			    store.idea = response.data;
			    this.subscribe(response.data.id);
		    });
	    },
	    methods: {
            subscribe(id) {
                this.channel = SocketService.subscribe(`idea.${id}`);
            }
        }
    }
</script>

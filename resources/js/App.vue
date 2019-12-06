<template>
    <div v-if="loaded">
        <div class="container">
            <Breadcrumbs
                :hackathon="hackathon"
                :idea="idea"
                :breadcrumbs="breadcrumbs"
                @sendIdeaTitleListener="sendIdeaTitle"
                :ideaTitle="ideaTitle"
            />
        </div>
        <router-view
            :hackathons="hackathons"
            :hackathon="hackathon"
            :idea="idea"
            :ideas="ideas"
            :user="user"
            :loginErrorMessage="loginErrorMessage"
            @sendIdeaTitleListener="sendIdeaTitle"
            :ideaTitle="ideaTitle"
        />
    </div>
</template>

<script>
    import Breadcrumbs from './components/Breadcrumbs.vue';

    export default {
        name: 'App',
        props: [
            'hackathons',
            'hackathon',
            'idea',
            'ideas',
            'user',
            'loginErrorMessage',
            'breadcrumbs'
        ],
	    data() {
		    return {
		    	loaded: false,
                ideaTitle: null,
		    }
        },
        components: {
            Breadcrumbs,
        },
        created() {
            this.loaded = true;
        },
        methods: {
            sendIdeaTitle(ideaTitle) {
	            this.ideaTitle = ideaTitle;
            }
        }
    }
</script>

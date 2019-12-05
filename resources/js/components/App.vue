<template>
    <div v-if="loaded">
        <Breadcrumbs :hackathon="hackathon" :idea="idea" :breadcrumbs="breadcrumbs" />
        <router-view
            :hackathons="hackathons"
            :hackathon="hackathon"
            :idea="idea"
            :ideas="ideas"
            :user="user"
            :loginErrorMessage="loginErrorMessage">
        </router-view>
    </div>
</template>

<script>
    import Breadcrumbs from './Breadcrumbs.vue';

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
		    }
        },
        components: {
            Breadcrumbs,
        },
        created() {
            this.loaded = true;
        }
    }
</script>

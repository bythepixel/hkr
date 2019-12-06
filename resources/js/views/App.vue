<template>
    <div v-if="loaded">
        <div class="container">
            <Breadcrumbs
                :hackathon="hackathon"
                :idea="idea"
                :breadcrumbs="breadcrumbs"
            />
        </div>
        <div class="container">
            <router-view
                :hackathons="hackathons"
                :hackathon="hackathon"
                :idea="idea"
                :ideas="ideas"
                :user="user"
                :loginErrorMessage="loginErrorMessage"
            />
        </div>
    </div>
</template>

<script>
    import Breadcrumbs from '../components/Breadcrumbs.vue';

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
        },
    }
</script>

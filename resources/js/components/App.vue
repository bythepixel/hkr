<template>
    <div>
        <Breadcrumbs :hackathon="hackathon" :idea="idea" :feature="feature" :breadcrumbs="breadcrumbs" />
        <router-view
            :hackathons="hackathons"
            :hackathon="hackathon"
            :idea="idea"
            :ideas="ideas"
            :feature="feature"
            :features="features"
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
            'feature',
            'features',
            'user',
            'loginErrorMessage',
            'breadcrumbs'
        ],
        components: {
            Breadcrumbs,
        },
    }
</script>

<style scoped>

</style>

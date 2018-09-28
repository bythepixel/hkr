<template>
    <div>
        <Idea :idea="idea" />
    </div>
</template>

<script>
    import Idea from '../components/Idea.vue';
    export default {
        name: "IdeaView",
        props: ['idea'],
        components: {
            Idea,
        }
    }
</script>

<style scoped>

</style>

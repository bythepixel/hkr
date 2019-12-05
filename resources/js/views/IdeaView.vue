<template>
    <div>
        <Idea :idea="this.$route.params.ideaId" />
    </div>
</template>

<script>
    import Idea from '../components/Idea.vue';
    export default {
        name: "IdeaView",
        components: {
            Idea,
        },
    }
</script>

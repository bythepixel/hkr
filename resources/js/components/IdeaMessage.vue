<template></template>

<script>
    import ChildIdeaMessage from './ChildIdeaMessage.vue';

    export default {
        name: "IdeaMessage",
        props: ['message', 'user'],
        components: {
            ChildIdeaMessage,
        }
    }
</script>

<style scoped></style>

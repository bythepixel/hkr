<template></template>

<script>
    import ChildFeatureMessage from './ChildFeatureMessage.vue';

    export default {
        name: "FeatureMessage",
        props: ['message', 'user'],
        components: {
            ChildFeatureMessage,
        }
    }
</script>

<style scoped>

</style>

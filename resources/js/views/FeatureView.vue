<template>
    <div>
        <Feature :feature="feature" />
    </div>
</template>

<script>
    import Feature from '../components/Feature.vue';

    export default {
        name: "FeatureView",
        components: {
            Feature,
        }
    }
</script>

<style scoped></style>

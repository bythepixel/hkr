<template>
    <div>
        <h2>{{ feature.title }}</h2>

        <ul>
            <div>
                <p>New feature message</p>
            </div>

            <li v-for="message in feature.message" :key="message.id">
                <FeatureMessage :message="message" />
            </li>
        </ul>
    </div>
</template>

<script>
    import FeatureMessage from './FeatureMessage.vue';

    export default {
        name: "Feature",
        props: ['feature'],
        components: {
            FeatureMessage,
        }
    }
</script>

<style scoped>

</style>

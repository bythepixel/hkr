<template>
    <div>
        <div>
            <h2>{{ idea.title }}</h2>
        </div>

        <div>
            <p>Features</p>

            <div v-for="feature in idea.features" :key="feature.id">
                <FeatureVote :votes="feature.votes" />
                <Feature :feature="feature" />
            </div>


        </div>

        <div class="messages">
            <div>
                <p>New idea message</p>
            </div>
            <div v-for="message in idea.messages" :key="message.id">
                <IdeaMessage :message="message" />
            </div>
        </div>
    </div>
</template>

<script>
    import Feature from './Feature.vue';
    import FeatureVote from './FeatureVote.vue';
    import IdeaMessage from './IdeaMessage.vue';

    export default {
        name: "Idea",
        props: ['idea'],
        components: {
            Feature,
            FeatureVote,
            IdeaMessage,
        }
    }
</script>

<style scoped>

</style>

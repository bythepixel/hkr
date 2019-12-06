<template>
    <div>
        <Idea
            :idea="this.$route.params.ideaId"
            @ideaTitle="sendIdeaTitleListener"
            :ideaTitle="ideaTitle"
        />
    </div>
</template>

<script>
    import Idea from '../components/Idea.vue';

    export default {
        name: "IdeaView",
        props: ['ideaTitle'],
        components: {
            Idea,
        },
	    methods: {
            sendIdeaTitleListener(ideaTitle) {
                this.$emit('sendIdeaTitleListener', ideaTitle);
            }
	    }
    }
</script>

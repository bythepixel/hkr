<template>
    <div>
        <div class="container">
            <Idea
                :idea="this.$route.params.ideaId"
                @ideaTitleChanged="handleIdeaTitleEvent"
                @ideaMessagesChanged="handleIdeaMessagesEvent"
            />
        </div>
        <IdeaMessage :ideaMessages="ideaMessages" />
    </div>
</template>

<script>
    import Idea from '../components/Idea';
    import IdeaMessage from "../components/IdeaMessage";

    export default {
        name: "IdeaView",
        props: ['ideaTitle'],
        components: {
            Idea,
            IdeaMessage
        },
        data() {
            return {
	            ideaMessages: null,
            }
        },
	    methods: {
            handleIdeaTitleEvent(ideaTitle) {
                this.$emit('ideaTitleChanged', ideaTitle);
            },
            handleIdeaMessagesEvent(ideaMessages) {
                this.ideaMessages = ideaMessages;
            }
	    }
    }
</script>

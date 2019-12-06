<template>
    <div>
        <div class="container">
            <Idea
                :idea="this.$route.params.ideaId"
                @ideaTitleChanged="handleIdeaTitleEvent"
                @ideaMessagesChanged="handleIdeaMessagesEvent"
            />
        </div>
        <IdeaMessages :ideaMessages="ideaMessages" />
    </div>
</template>

<script>
    import Idea from '../components/Idea';
    import IdeaMessages from "../components/IdeaMessages";

    export default {
        name: "IdeaView",
        props: ['ideaTitle'],
        components: {
            Idea,
            IdeaMessages
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

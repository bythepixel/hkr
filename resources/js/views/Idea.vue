<template>
    <div>
        <div class="container">
            <Idea
                :idea="this.$route.params.ideaId"
                @ideaTitle="sendIdeaTitleListener"
                :ideaTitle="ideaTitle"
            />
        </div>
        <div class="messages">
            <div class="container">
                <div class="messages__submit">
                    <div class="field-wrapper">
                        <input type="text" name="comment" required="">
                        <label>Join the conversation...</label>
                    </div>
                    <p class="small-text">Press "Enter" to Add</p>
                </div>
                <ul class="messages__message message">
                    <li class="message__item">
                        <p class="message__name">John Doe <span class="small-text message__time">a min ago</span></p>
                        <p class="message__content">Unicorn franzen you probably haven’t heard of them coloring book. Vape vaporware meh, cardigan trust fund.</p>
                        <p class="message__reply"><a href="#">Reply</a></p>
                    </li>
                </ul>
            </div>
        </div>
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

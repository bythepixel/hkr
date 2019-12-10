<template>
    <div v-if="!!idea">
        <div class="idea">
            <IdeaVote :idea="idea" :hackathon="hackathon" />
            <div class="idea__content">
                <h2 class="idea__title">{{ idea.title }}</h2>
                <p class="idea__author">{{ idea.user.name }}, {{ idea.messages.length }} Comments</p>
                <p class="idea__description">{{ idea.description }}</p>
                <div v-if="idea.long_description" class="idea__long_description rendered-markdown">
                    <VueShowdown :markdown="idea.long_description"/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import IdeaVote from './IdeaVote.vue';
    import ShowdownService from '../services/ShowdownService';

    export default {
	    name: "Idea",
        props: [
        	'idea',
            'hackathon'
        ],
	    components: {
            IdeaVote,
            ShowdownService
	    }
    }
</script>

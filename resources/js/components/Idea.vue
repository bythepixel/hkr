<template>
  <div v-if="!!idea">
    <div class="idea">
      <IdeaVote :idea="idea" :hackathon="hackathon"/>
      <div class="idea__content">
        <h2 class="idea__title">{{ idea.title }}</h2>
        <p class="idea__author">
          By {{ idea.user.name }} on {{ idea.created_at }},
          <span v-if="idea.messages">{{ idea.messages.length }}</span>
          <span v-else>0</span>
          Comments
        </p>
        <p class="idea__description">{{ idea.description }}</p>
        <div v-if="idea.long_description" class="idea__long_description rendered-markdown">
          <VueShowdown :markdown="idea.long_description"/>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
  import IdeaVote from './IdeaVote.vue'

  export default {
    name: 'Idea',
    props: [
      'idea',
      'hackathon'
    ],
    components: {
      IdeaVote,
    }
  }
</script>

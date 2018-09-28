<template>
    <div>
        <NewIdeaForm :user="user" :hackathon="hackathon" />
    </div>
</template>

<script>
    import NewIdeaForm from '../components/NewIdeaForm.vue';

    export default {
        name: "NewIdeaView",
        props: ['user', 'hackathon'],
        components: {
            NewIdeaForm,
        }
    }
</script>

<style scoped>

</style>

<template>
    <div>
        <NewHackathonForm :user="user" />
    </div>
</template>

<script>
    import NewHackathonForm from '../components/NewHackathonForm.vue';

    export default {
        name: "NewHackathonView",
        props: ['user'],
        components: {
            NewHackathonForm,
        }
    }
</script>

<style scoped>

</style>

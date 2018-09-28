<template>
    <div>
        <Login :loginErrorMessage="loginErrorMessage" />
    </div>
</template>

<script>
    import Login from '../components/Login.vue';

    export default {
        name: "LoginView",
        props: ['loginErrorMessage'],
        components: {
            Login
        }
    }
</script>

<style scoped>

</style>

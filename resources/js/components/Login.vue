<template>
    <div>
        <p v-if="errorMessage">{{ errorMessage }}</p>
        <div id="login">
            <form v-on:submit.prevent="onSubmit" class="container">
                <h1>Login</h1>
                <div class="field-wrapper">
                    <input type="text" v-model.trim="email" id="email" required="">
                    <label for="email">Username</label>
                </div>
                <div class="field-wrapper">
                    <input type="password" v-model.trim="password" id="password" required="">
                    <label for="password">Password</label>
                </div>
                <button role="button">Login</button>
            </form>
        </div>
    </div>
</template>

<script>
    import HttpService from 'axios';
    import LocalStorageService from "../services/LocalStorageService";

    import store from '../data/store.js';

    import { loginEndpoint } from '../config/endpoints.js';

    export default {
        name: "Login",
        props: ['errorMessage'],
        data() {
            return {
                email: null,
                password: null,
            }
        },
        methods: {
            /**
             * @param event {Event}
             */
            onSubmit(event) {
                this.errorMessage = null;

                if (!this.email || !this.password) {
                    // show error
                    return;
                }

                HttpService.post(loginEndpoint(), {
                    email: this.email,
                    password: this.password,
                }).then(response => {
                    if (response.status === 200) {
                        const data = response.data;

                        store.user = {
                            id: data.id,
                            name: data.name,
                        };

                        LocalStorageService.setAuth(data.api_token);
                        this.$router.push('/');
                        return;
                    }

                    this.errorMessage = response.data.message;
                })
            },
        }
    }
</script>

<style scoped>

</style>

<template>
    <div class="login">
        <div class="container">
            <form id="login" @submit.prevent="onSubmit">
                <h1 class="error">{{ loginErrorMessage }}</h1>
                <div class="field-wrapper">
                    <label for="email">Username</label>
                    <input type="email" v-model.trim="email" id="email">
                </div>
                <div class="field-wrapper">
                    <label for="password">Password</label>
                    <input type="password" v-model.trim="password" id="password">
                </div>
            </form>
        </div>
        <Footer>
            <button class="button" form="login">Login</button>
        </Footer>
    </div>
</template>

<script>
	import HttpService from 'axios';
	import LocalStorageService from "../services/LocalStorageService";

	import store from '../data/store.js';

	import { loginEndpoint } from '../config/endpoints.js';

    import Footer from '../components/Footer';

	export default {
		name: "LoginView",
        components: {
            Footer,
        },
		data() {
			return {
				email: null,
				password: null,
				loginErrorMessage: null,
			}
		},
		methods: {
			onSubmit() {
				if (!this.email || !this.password) {
					this.loginErrorMessage = "Please fill out both fields";
					return;
				}

				HttpService.post(loginEndpoint(), {
					email: this.email,
					password: this.password,
				}).then(response => {
					const data = response.data;
					if (response.status === 200 && data.loginErrorMessage === undefined) {
						store.user = {
							id: data.id,
							name: data.name,
						};

						LocalStorageService.setUser(store.user);
						LocalStorageService.setAuth(data.api_token);
						this.$router.push('/');
					} else {
						this.loginErrorMessage = data.loginErrorMessage;
					}
				})
			},
		}
	}
</script>

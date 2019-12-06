<template>
    <div>
        <form v-on:submit.prevent="onSubmit">
            <h1>Login</h1>
            <h1 class="error">{{ loginErrorMessage }}</h1>
            <div class="field-wrapper">
                <input type="text" v-model.trim="email" id="email" :class="{'has-value': email}">
                <label for="email">Username</label>
            </div>
            <div class="field-wrapper">
                <input type="password" v-model.trim="password" id="password" :class="{'has-value': password}">
                <label for="password">Password</label>
            </div>
            <button role="button">Login</button>
        </form>
    </div>
</template>

<script>
	import HttpService from 'axios';
	import LocalStorageService from "../services/LocalStorageService";

	import store from '../data/store.js';

	import { loginEndpoint } from '../config/endpoints.js';

	export default {
		name: "LoginView",
		data() {
			return {
				email: null,
				password: null,
				loginErrorMessage: null,
			}
		},
		methods: {
			/**
			 * @param event {Event}
			 */
			onSubmit(event) {

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

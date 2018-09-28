const AUTH_KEY = 'hkr-session',
    USER_KEY = 'hkr-user';

import HttpService from 'axios';

const localStorageService = new class {
    get(key) {
        return localStorage.getItem(key);
    }

    set({key, value}) {
        localStorage.setItem(key, value);
    }

    remove(key) {
        localStorage.removeItem(key);
    }

    getUser() {
        const userJson = this.get(USER_KEY);
        if (!userJson) {
            return null;
        }

        return JSON.parse(userJson);
    }

    setUser(value) {
        this.set({key: USER_KEY, value: JSON.stringify(value)});
    }

    getAuth() {
        return this.get(AUTH_KEY);
    }

    setAuth(value) {
        this.set({key: AUTH_KEY, value});
        HttpService.defaults.headers.common = {'Authorization': `Bearer ${value}`};
    }

    removeAuth() {
        this.remove(AUTH_KEY);
    }
};

export default localStorageService;

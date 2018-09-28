const AUTH_KEY = 'hkr-session';

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

    getAuth() {
        return this.get(AUTH_KEY);
    }

    setAuth(value) {
        this.set({key: AUTH_KEY, value});
        HttpService.defaults.headers.common = {'Authorization': `bearer ${value}`};
    }

    removeAuth() {
        this.remove(AUTH_KEY);
    }
};

export default localStorageService;

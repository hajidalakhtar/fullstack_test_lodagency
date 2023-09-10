import {createStore} from "vuex";
import axiosClient from "@/axiosClient";

const store = createStore({
    state: {
        user: null,
    },
    getters: {
        isAuthenticated(state) {
            return !!state.user;
        },
        getUser(state) {
            return state.user;
        },
        getToken(state) {
            return state.user.token;
        },
    },
    mutations: {
        initialiseStore(state) {
            if (localStorage.getItem('store')) {
                this.replaceState(
                    Object.assign(state, JSON.parse(localStorage.getItem('store')))
                );
            }
        },
        SET_USER(state, user) {
            state.user = user;
        },
    },
    actions: {
        login({commit}, {email, password}) {
            let loginData = new FormData();
            loginData.append('username', email);
            loginData.append('password', password);
            axiosClient
                .post('login', loginData)
                .then(({data}) => {
                    commit('SET_USER', data.data);
                })
                .catch(err => {
                    console.error(err);
                });
        },
        register({commit}, {username, password, email, fullname}) {
            let register = new FormData();
            register.append('username', username);
            register.append('password', password);
            register.append('email', email);
            register.append('fullname', fullname);

            axiosClient
                .post('register', register)
                .then(({data}) => {
                    commit('SET_USER', data.data);
                })
                .catch(err => {
                    console.error(err);
                });
        },
        logout({commit}) {
            commit('SET_USER', null);
        },
    },
})


store.subscribe((mutation, state) => {
    localStorage.setItem('store', JSON.stringify(state));
});


export default store
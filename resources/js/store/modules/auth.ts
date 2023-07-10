import { Module } from "vuex";
import api from "../../api";
import UserInterface from "../../interfaces/UserInterface";

interface AuthState {
    token: string | null,
    errors: [] | null,
    authenticated: Boolean,
    user: UserInterface | null,
}

const authModule: Module<AuthState, null> = {
    namespaced: true,
    state: {
        token: localStorage.getItem('token'),
        errors: null,
        authenticated: false,
        user: null
    },
    getters: {
        getToken: (state) => state.token,
        getErrors: (state) => state.errors,
        getAuthenticated: (state) => state.authenticated,
        getUser: (state) => state.user,
    },
    mutations: {
        SET_TOKEN(state, data) {
            state.token = data;
        },
        SET_ERRORS(state, data) {
            state.errors = data;
        },
        SET_AUTHENTICATED(state, data) {
            state.authenticated = data;
        },
        SET_USER(state, data) {
            state.user = data;
        }
    },
    actions: {
        async login({ commit, dispatch }, credentials) {
            return api.post("/auth/login", credentials)
                .then(res => {
                    const { data } = res;
                    localStorage.setItem('token', data.access_token);
                    commit('SET_ERRORS', null);
                    commit('SET_AUTHENTICATED', true);
                    commit('SET_TOKEN', data.access_token);
                    dispatch('me');
                })
                .catch(error => {
                    if (error.response) {
                        const { data, status } = error.response;
                        if (status == 403) {
                            commit('SET_AUTHENTICATED', true);
                            return;
                        }
                        commit('SET_ERRORS', data.errors);
                        commit('SET_AUTHENTICATED', false);
                        commit('SET_TOKEN', null);
                        localStorage.removeItem('token');
                    }
                });
        },
        async me({ commit }) {
            return api.get('/auth/me').then(res => {
                const { data, status } = res;
                if (status == 200) {
                    commit('SET_USER', data);
                    commit('SET_AUTHENTICATED', true);
                }
            }).catch(err => {
                commit('SET_AUTHENTICATED', false);
                commit('SET_TOKEN', null);
                commit('SET_USER', null);
                localStorage.removeItem('token');
            })
        },
        async logout({ commit }) {
            return api.post('/auth/logout').then(res => {
                const { status } = res;
                if (status == 204) {
                    commit('SET_AUTHENTICATED', false);
                    commit('SET_TOKEN', null);
                    localStorage.removeItem('token');
                    commit('SET_USER', null);
                }
            });
        },
        async delete({ commit }) {
            return api.post('/user/delete')
                .then(res => {
                    const { status } = res;
                    if (status == 204) {
                        commit('SET_AUTHENTICATED', false);
                        commit('SET_TOKEN', null);
                        localStorage.removeItem('token');
                        commit('SET_USER', null);
                    }
                })
        }
    },
}

export default authModule;
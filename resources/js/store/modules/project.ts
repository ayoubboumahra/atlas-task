import { Module } from "vuex";
import api from "../../api";
import ProjectInterface from "../../interfaces/ProjectInterface";

interface ProjectState {
    projects: ProjectInterface[],
    errors: [] | null,
}

const projectModule: Module<ProjectState, null> = {
    namespaced: true,
    state: {
        projects: [],
        errors: null,
    },
    getters: {
        getProjects: (state) => state.projects,
        getErrors: (state) => state.errors,
    },
    mutations: {
        SET_PROJECTS(state, data) {
            state.projects = data;
        },
        SET_ERRORS(state, data) {
            state.errors = data;
        },
    },
    actions: {
        async list({ commit }) {
            return api.get("/projects")
                .then(res => {
                    const { data } = res;
                    commit('SET_PROJECTS', data.projects);
                });
        },
        async store({ commit, dispatch }, inputs) {
            return api.post("/projects", inputs)
                .then(res => {
                    const { status } = res;
                    if (status === 204) {
                        commit('SET_ERRORS', null);
                        dispatch('list');
                    }
                })
                .catch(error => {
                    if (error.response) {
                        const { data } = error.response;
                        commit('SET_ERRORS', data.errors);
                    }
                });
        },
        async delete({ dispatch }, id: number) {
            return api.delete(`/projects/${id}`)
                .then(res => {
                    const { status } = res;
                    if (status === 204) {
                        dispatch('list');
                    }
                });
        },
    },
}

export default projectModule;
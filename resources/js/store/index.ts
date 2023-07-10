import { createStore } from "vuex";
import authModule from "./modules/auth";
import projectModule from "./modules/project";

export default createStore({
    modules: {
        auth: authModule,
        projects: projectModule,
    }
});
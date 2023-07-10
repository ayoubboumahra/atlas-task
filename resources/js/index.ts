import { createApp } from "vue";
import router from "./router";
import store from "./store";
import App from "./app.vue";
import "./bootstrap"
import Vue3DraggableResizable from 'vue3-draggable-resizable'
import 'vue3-draggable-resizable/dist/Vue3DraggableResizable.css'

createApp(App).use(Vue3DraggableResizable).use(store).use(router).mount("#app");
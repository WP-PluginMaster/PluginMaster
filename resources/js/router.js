import Vue from 'vue'
import Router from "vue-router";
import Notes from "./components/Notes.vue";
import Home from "./components/Home.vue";

Vue.use(Router);

export default new Router({
    mode: "hash",
    routes: [
        {
            path: "/Home",
            name: "Home",
            component: Home,
            meta: {
                title: "Home"
            }
        },
        {
            path: "/Notes",
            name: "Notes",
            component: Notes,
            meta: {
                title: "Notes"
            }
        }

    ],
    scrollBehavior(to, from, savedPosition) {
        if (savedPosition) {
            return savedPosition;
        } else {
            return {
                x: 0,
                y: 0
            };
        }
    }
});

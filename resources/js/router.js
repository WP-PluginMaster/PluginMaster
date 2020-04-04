import Vue from 'vue'
import Router from "vue-router";
import Notes from "./components/Notes.vue";
import Dashboard from "./components/Dashboard.vue";

Vue.use(Router);

export default new Router({
    mode: "hash",
    routes: [
        {
            path: "/",
            name: "Home",
            component: Notes,
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
        },
        {
            path: "/Dashboard",
            name: "Dashboard",
            component: Dashboard,
            meta: {
                title: "Dashboard"
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

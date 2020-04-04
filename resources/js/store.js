import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);

const store = new Vuex.Store({
    state: {
        notePage: {
            title: "Personal Notes",
            head: "Notes"
        },
        homePage: {
            title: "PluginMaster (an Application Development Framework for Wordpress)",
            head: "Documentation"
        },
    },
    mutations: {

    },
    actions: {

    }
});


export default store;

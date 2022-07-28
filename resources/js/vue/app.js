import Vue from 'vue'

import App from './app.vue'


new Vue({
    el: '#VueApp',
    template: '<App/>',
    components: {App},
    data: function () {
        return {
            name: 'PluginMaster'
       }
    },
    methods: {

    }
})

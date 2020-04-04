import Vue from 'vue'


import router from './router.js'
import store from './store.js'
import App from './app.vue'

new Vue({
    router: router,
    store: store ,
    el: "#vueApplication",
    render: h => h(App)
});


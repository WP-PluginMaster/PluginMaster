import {createApp} from 'vue'

import App from './App.vue'


if( document.getElementById('vueApp') ) {

    const app = createApp(App)

    app.mount('#vueApp')

}
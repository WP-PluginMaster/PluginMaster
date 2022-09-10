
let builder = require("bundle-master")

module.exports = builder
    .react('resources/js/react/app.js', 'assets/js/react/app.js')
    .vue('resources/js/vue/app.js', 'assets/js/vue/app.js')
    .scss('resources/scss/app.scss', 'assets/css/app.css')
    .init();

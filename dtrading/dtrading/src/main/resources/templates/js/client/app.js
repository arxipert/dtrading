require('./bootstrap');

window.Vue = require('vue');

Vue.config.devtools = true;
Vue.config.performance = true;

import Vue from 'vue';
import App from './components/App.vue';

import VeeValidate from 'vee-validate';


Vue.use(VeeValidate);
Vue.use(require('vue-moment'));

new Vue({
    el: '#app',
    components: {
        App
    },
    render: h => h(App)
});

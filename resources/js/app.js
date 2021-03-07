
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

require('./bootstrap');

window.Vue = require('vue');
import router from './router';
import store from './store';
import ViewUI from 'view-design';
import common from './common';



// import Editor from 'vue-editor-js'

// Vue.use(Editor)
Vue.use(ViewUI);
Vue.mixin(common);
Vue.component('mainapp',require('./component/mainapp.vue').default)

const app  = new Vue({
    el:'#app',
    router,
    store,


});

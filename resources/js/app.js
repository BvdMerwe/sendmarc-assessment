require('./bootstrap');

import Vue from 'vue'
import App from './App.vue'

Vue.config.productionTip = false;

new Vue({
  render: h => h(App),
}).$mount('#app')

// window.Vue = require('vue');

// Vue.component(
//     'App',
//     require('./App.vue')
// );

// const app = new Vue({
//     el: "#app"
// })
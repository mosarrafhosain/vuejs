import Vue from 'vue'
import App from './App.vue'
import VueRouter from 'vue-router'
import axios from 'axios'

Vue.use(VueRouter)

Vue.config.productionTip = false

var eventBus = new Vue();
Vue.prototype.$eventBus = eventBus;

Vue.prototype.$axios = axios;

new Vue({
  render: h => h(App),
}).$mount('#app')

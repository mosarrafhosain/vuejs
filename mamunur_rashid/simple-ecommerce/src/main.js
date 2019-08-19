import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import iziToast from 'izitoast';
import Login from './components/pages/Login.vue';
import Admin from './components/pages/admin/Admin.vue';
import Category from './components/pages/admin/Category.vue';
import Modal from './components/others/Modal.vue';

Vue.config.productionTip = false;
Vue.use(VueRouter);

var eventBus = new Vue();
Vue.prototype.$eventBus = eventBus;
Vue.prototype.$axios = axios;
Vue.prototype.$iziToast = iziToast;

Vue.component('modal', Modal);

const routes = [
  {
    path: '/',
    name: 'helloworld',
    redirect: { path: 'login' }
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/admin',
    name: 'admin',
    component: Admin,
    redirect: { path: '/admin/category' },
    children: [
      {
        path: 'category',
        name: 'admin.category',
        component: Category
      }
    ]
  }
];

const router = new VueRouter({
  routes, // short for `routes: routes`
  mode: 'history'
});

new Vue({
  render: h => h(App),
  router
}).$mount('#app');

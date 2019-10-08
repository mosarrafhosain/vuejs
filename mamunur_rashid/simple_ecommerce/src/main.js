import Vue from 'vue';
import App from './App.vue';
import VueRouter from 'vue-router';
import axios from 'axios';
import iziToast from 'izitoast';
import store from './store';

import Login from './components/pages/Login.vue';
import Admin from './components/pages/admin/Admin.vue';
import Category from './components/pages/admin/Category.vue';
import Supplier from './components/pages/admin/Supplier.vue';
import Product from './components/pages/admin/Product.vue';

import Shop from './components/pages/shop/Shop.vue';
import ShopProducts from './components/pages/shop/ShopProducts.vue';
import ShopProduct from './components/pages/shop/ShopProduct.vue';
import Checkout from './components/pages/shop/Checkout.vue';

import Modal from './components/others/Modal.vue';

Vue.config.productionTip = false;
Vue.use(VueRouter);

var eventBus = new Vue();
Vue.prototype.$eventBus = eventBus;
Vue.prototype.$axios = axios;
Vue.prototype.$iziToast = iziToast;
Vue.prototype.$apiBaseUrl =
  'http://localhost/github/mosarrafhosain/vuejs/mamunur_rashid/simple_ecommerce/api/public';

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
      },
      {
        path: 'supplier',
        name: 'admin.supplier',
        component: Supplier
      },
      {
        path: 'product',
        name: 'admin.product',
        component: Product
      }
    ]
  },
  {
    path: '/shop',
    name: 'shop',
    component: Shop,
    redirect: { path: '/shop/products' },
    children: [
      {
        path: 'products',
        name: 'shop.products',
        component: ShopProducts
      },
      {
        path: 'product/:pid',
        name: 'shop.product',
        component: ShopProduct
      },
      {
        path: 'checkout',
        name: 'shop.checkout',
        component: Checkout
      }
    ]
  }
];

const router = new VueRouter({
  routes, // short for `routes: routes`
  mode: 'history'
});

router.beforeEach((to, from, next) => {
  axios.defaults.headers.common['Authorization'] =
    'Token ' + localStorage.getItem('token');
  next();
});

new Vue({
  render: h => h(App),
  router,
  store
}).$mount('#app');

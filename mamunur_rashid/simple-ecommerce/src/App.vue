<template>
  <div id="app">
    <div id="loading" v-if="loading">
      <img src="../public/img/loading.gif" alt="">
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
import VueRouter from 'vue-router'
import HelloWorld from './components/HelloWorld.vue'
import Login from './components/pages/Login.vue'

const routes = [
  { path: '/', redirect: {path: "/login"} },
  { path: '/login', component: Login }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
  routes, // short for `routes: routes`
  mode: 'history'
})

export default {
  name: 'app',
  components: {
    HelloWorld
  },
  router,
  data(){
    return {
      loading: false
    }
  },
  created() {
    this.$eventBus.$on("loadingStatus", payload => {
      this.loading = payload;
    });
  },
}
</script>

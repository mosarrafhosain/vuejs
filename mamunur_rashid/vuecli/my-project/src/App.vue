<template>
  <div id="app">
    <!---header---->
    <div class="header">
      <div class="container">
        <div class="logo">
          <router-link to="/"><img src="logo.jpg" title /></router-link>
        </div>
        <!---start-top-nav---->
        <div class="top-menu">
          <div class="search">
            <form>
              <input type="text" placeholder required />
              <input type="submit" value />
            </form>
          </div>
          <span class="menu"></span>
          <ul>
            <li> <router-link to="/" exact>HOME</router-link> </li>
            <li> <router-link to="/services">SERVICES</router-link> </li>
            <li> <router-link to="/about">ABOUT</router-link> </li>
            <li> <router-link to="/contact">CONTACT</router-link> </li>
            <div class="clearfix"></div>
          </ul>
        </div>
        <div class="clearfix"></div>
        <!---//End-top-nav---->
      </div>
    </div>
    <!--/header-->
    <!---728x90--->

    <div class="content">
      <div class="container">
        <div class="content-grids">
          <router-view></router-view>
          <div class="col-md-4 content-right">
            <div class="recent">
              <h3>RECENT POSTS</h3>
              <ul>
                <li>
                  <a href="#">Aliquam tincidunt mauris</a>
                </li>
                <li>
                  <a href="#">Vestibulum auctor dapibus lipsum</a>
                </li>
                <li>
                  <a href="#">Nunc dignissim risus consecu</a>
                </li>
                <li>
                  <a href="#">Cras ornare tristiqu</a>
                </li>
              </ul>
            </div>
            <div class="comments">
              <h3>RECENT COMMENTS</h3>
              <ul>
                <li>
                  <a href="#">Amanda Doe</a> on
                  <a href="#">Hello World!</a>
                </li>
                <li>
                  <a href="#">Peter Doe</a> on
                  <a href="#">Photography</a>
                </li>
                <li>
                  <a href="#">Steve Roberts</a> on
                  <a href="#">HTML5/CSS3</a>
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
            <div class="archives">
              <h3>ARCHIVES</h3>
              <ul>
                <li>
                  <a href="#">October 2013</a>
                </li>
                <li>
                  <a href="#">September 2013</a>
                </li>
                <li>
                  <a href="#">August 2013</a>
                </li>
                <li>
                  <a href="#">July 2013</a>
                </li>
              </ul>
            </div>
            <div class="categories">
              <h3>CATEGORIES</h3>
              <ul>
                <li>
                  <a href="#">Vivamus vestibulum nulla</a>
                </li>
                <li>
                  <a href="#">Integer vitae libero ac risus e</a>
                </li>
                <li>
                  <a href="#">Vestibulum commo</a>
                </li>
                <li>
                  <a href="#">Cras iaculis ultricies</a>
                </li>
              </ul>
            </div>
            <div class="clearfix"></div>
          </div>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <!---728x90--->

    <!---->
    <div class="footer">
      <div class="container">
        <p>
          © 2019 Personal Blog . All rights reserved | Template by
          <a
            target="_blank"
            href="http://mosarrafhosain.com/"
          >Mosarraf Hosain</a>
        </p>
      </div>
    </div>
  </div>
</template>

<script>
import VueRouter from 'vue-router'
import HelloWorld from "./components/HelloWorld.vue";
import Home from "./components/Home.vue";
import Services from "./components/Services.vue";
import About from "./components/About.vue";
import Contact from "./components/Contact.vue";

const routes = [
  { path: '/', component: Home },
  { path: '/services', component: Services },
  { path: '/about', component: About },
  { path: '/contact', component: Contact }
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = new VueRouter({
  routes, // short for `routes: routes`
  mode: 'history'
})

export default {
  name: "app",
  components: {
    HelloWorld
  },
  router
};
</script>

<template>
  <div class="admin">
    <Header />
    <LeftSidebar />

    <div id="main">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import Header from "../../others/Header.vue";
import LeftSidebar from "../../others/LeftSidebar.vue";

export default {
  name: "Admin",
  data() {
    return {};
  },
  mounted() {
    var token = localStorage.getItem("token");
    if (!token) {
      this.$router.push({ name: "login" });
    }
  },
  methods: {
    
  },
  components: {
    Header,
    LeftSidebar
  }
};
</script>

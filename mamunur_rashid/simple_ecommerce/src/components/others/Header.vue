<template>
  <div id="header">
    <h1 class="fleft">
      <a href="/admin">Simple Ecommerce</a>
    </h1>
    <a href="javascript:void(0)" class="fright" @click="logoutNow()">Logout</a>
  </div>
</template>

<script>
export default {
  name: "Header",
  data() {
    return {

    };
  },
  methods: {
    logoutNow() {
      localStorage.setItem("token", "");
      this.$router.push({ name: "login" });
    }
  }
};
</script>

<template>
  <div id="app">
    <div id="loading" v-if="loading">
      <img src="./assets/img/loading.gif" />
    </div>
    <router-view></router-view>
  </div>
</template>

<script>
export default {
  name: "App",
  data() {
    return {
      loading: false
    };
  },

  created() {
    this.$eventBus.$on("loadingStatus", payload => {
      this.loading = payload;
    });
  }
};
</script>

<template>
  <div>
    <h1>Latest Products</h1>
    <hr />
  </div>
</template>

<script>
export default {
  name: "ShopProducts",
  data() {
    return {};
  },
  mounted() {
    console.log("Mounted");
    this.init();
  },
  methods: {
    init() {}
  }
};
</script>

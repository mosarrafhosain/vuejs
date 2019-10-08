<template>
  <div>
    <h1>Latest Products</h1>
    <hr />
    <div class="product" v-for="product in allProducts">
      <router-link :to="'/shop/product/' + product.id">
        <div class="productContainer">
          <img :src="$apiBaseUrl + '/' + product.image" alt="image">
          <br><br>
          <strong> {{ product.name }} </strong>
          <p class="price">&#2547; {{ product.price }} </p>
        </div>
      </router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: "ShopProducts",
  data() {
    return {
      allProducts: []
    };
  },
  mounted() {
    console.log("Mounted");
    this.init();
  },
  methods: {
    init() {
      this.$eventBus.$emit("loadingStatus", true);
      this.$axios.get(this.$apiBaseUrl + "/get-products").then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.allProducts = res.data.products;
        }
      });
    }
  }
};
</script>

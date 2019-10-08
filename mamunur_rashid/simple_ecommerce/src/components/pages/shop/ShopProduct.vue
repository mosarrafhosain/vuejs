<template>
  <div>
    <h1 class="fleft"> {{ product.name }} </h1>
    <router-link to="/shop/products" class="fright"> All Products </router-link>
    <div class="clear"></div>
    <hr />
    <div class="product-left">
      <img :src="$apiBaseUrl + '/' + product.image" alt="image">
      <br>
    </div>
    <div class="product-right">
      <div class="product-description">
        <p>
          <strong>Category:</strong> {{ product.category }} <br><br>
          <strong>Supplier:</strong> {{ product.supplier }} <br><br>
          <strong>Price:</strong> {{ product.price }} <br><br>
          <strong>Description:</strong> {{ product.description }} <br><br>
        </p>
        <strong>Quantity: </strong>
        <input type="number" clase="input-number" v-model="qty">
        <button class="addBtn" @click="addToCart()"> Add to cart </button>
      </div>
    </div>
    <div class="clear"></div>
    <br><br><br><br>
    <p class="txt-center">
      <router-link to="/shop/products" class="addBtn"> Continue Shopping </router-link>
    </p>
  </div>
</template>

<script>
export default {
  name: "ShopProduct",
  data() {
    return {
      productId: 0,
      product: {},
      qty: 1
    };
  },
  mounted() {
    this.productId = this.$route.params.pid;
    console.log(this.productId);
    this.init();
  },
  methods: {
    init() {
      this.$eventBus.$emit("loadingStatus", true);
      this.$axios.get(this.$apiBaseUrl + "/get-product/" + this.productId).then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.product = res.data.product;
          console.log(this.product);
        }
      });
    },
    addToCart(){
      //this.$eventBus.$emit("addToCart", {product: this.product, quantity: this.qty});
      this.$store.commit("addToCart", {product: this.product, quantity: this.qty});
    }
  }
};
</script>

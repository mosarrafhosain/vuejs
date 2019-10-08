<template>
  <div class="admin">
    <div id="header">
      <h1 class="fleft">Simple Ecommerce</a></h1>
      <router-link to="/admin" class="fright"> Dashboard </router-link>
    </div>
    <div id="shop">
      <div id="shopContainer">
        <router-view></router-view>
      </div>
    </div>
    <div id="cart">
      <Cart />
    </div>
  </div>
</template>

<script>
import Cart from "../../others/Cart.vue";

export default {
  name: "Shop",
  data() {
    return {
      cart: []
    };
  },
  computed: {
    total(){
      var total = 0;
      for(var i = 0; i < this.cart.length; i++){
        var item = this.cart[i];
        total += item.quantity * item.product.price;
      }
      return total;
    }
  },
  mounted() {
    var token = localStorage.getItem("token");
    if (!token) {
      this.$router.push({ name: "login" });
    }
    this.$eventBus.$on("addToCart", payload => {
      this.cart.push(payload);
    });
    this.$eventBus.$on("clearCart", payload => {
      this.cart = [];
    });
  },
  methods: {
    logoutNow() {
      localStorage.setItem("token", "");
      this.$router.push({ name: "login" });
    }
  },
  components: {
    Cart
  }
};
</script>

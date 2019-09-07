<template>
  <div class="admin">
    <div id="header">
      <h1 class="fleft">
        <a href="/admin">Simple Ecommerce</a>
      </h1>
      <a href="javascript:void(0)" class="fright" @click="logoutNow()">Logout</a>
    </div>
    <div id="shop">
      <div id="shopContainer">
        <router-view></router-view>
      </div>
    </div>
    <div id="cart">
      <div id="cartContainer">
        <h2>Your Cart</h2>
        <hr />
        <table class="cart">
          <tr>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Shop",
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
    logoutNow() {
      localStorage.setItem("token", "");
      this.$router.push({ name: "login" });
    }
  }
};
</script>

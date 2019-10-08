<template>
  <div>
    <h1 class="fleft"> Delivery Information </h1>
    <router-link to="/shop/products" class="fright">
      All Products
    </router-link>
    <div class="clear"></div>
    <hr>
    <table>
      <tr>
        <td>Full Name</td>
        <td><input type="text" placeholder="Full Name"></td>
      </tr>
      <tr>
        <td>City</td>
        <td>
          <select>
            <option value="">-- Select one --</option>
            <option>Dhaka</option>
            <option>Rajshahi</option>
            <option>Khulna</option>
            <option>Barishal</option>
            <option>Rangpur</option>
            <option>Sylhet</option>
            <option>Chittagong</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>Address</td>
        <td><textarea placeholder="Write delivery description"></textarea></td>
      </tr>
      <tr>
        <td>Mobile</td>
        <td><input type="text" placeholder="Mobile Number"></td>
      </tr>
      <tr>
        <td>Payment Method</td>
        <td>
          <select>
            <option value="">-- Select one --</option>
            <option>Cash on delivery</option>
            <option>Paypal</option>
            <option>bKash</option>
            <option>SureCash</option>
            <option>Master card</option>
          </select>
        </td>
      </tr>
      <tr>
        <td></td>
        <td><button class="btnSave" @click="orderNow()">Order Now</button></td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  name: "Checkout",
  data() {
    return {
      msg: 'Shop'
    };
  },
  mounted() {
    this.init();
  },
  methods: {
    init() {
      
    },
    orderNow(){
      this.$eventBus.$emit("loadingStatus", true);
      this.$axios.post(this.$apiBaseUrl + "/confirm-order", {}).then(res => {
        this.$eventBus.$emit("loadingStatus", false);

        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          this.$eventBus.$emit("clearCart");
          this.$iziToast.success({
            title: "OK",
            message: res.data.message
          });

          this.$router.push({path: '/shop/products'});
        }
      }).catch(err => {
        
      });
    }
  }
};
</script>

<template>
  <div id="sidebar">
    <ul class="nav">
      <li>
        <router-link to="/admin/category">Category</router-link>
      </li>
      <li>
        <router-link to="/admin/supplier">Supplier</router-link>
      </li>
      <li>
        <router-link to="/admin/product">Product</router-link>
      </li>
      <li>
        <router-link to="/shop">Shop</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  name: "LeftSidebar",
  data() {
    return {

    };
  }
};
</script>

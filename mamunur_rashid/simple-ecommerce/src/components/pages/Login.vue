<template>
  <div class="login">
    <div class="loginHeader">User Login</div>

    <div class="loginContainer">
      <table>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td> <input type="text" placeholder="Username" v-model="user.username"> </td>
        </tr>

        <tr>
          <td>Password</td>
          <td>:</td>
          <td> <input type="password" placeholder="Password" v-model="user.password"> </td>
        </tr>

        <tr>
          <td></td>
          <td></td>
          <td> <button class="addBtn" @click="loginNow()">Login</button> </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data(){
    return {
      user: {
        username: "",
        password: ""
      }
    }
  },
  methods: {
    loginNow(){
      console.log(this.user);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios.post("http://localhost/github/mosarrafhosain/vuejs/mamunur_rashid/simple-ecommerce/api/", this.user)
      .then(res => {
        this.$eventBus.$emit("loadingStatus", false);
        console.log(res);
      });
    }
  },
};
</script>

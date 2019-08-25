<template>
  <div class="login">
    <div class="loginHeader">User Login</div>

    <div class="loginContainter">
      <table>
        <tr>
          <td>Username</td>
          <td>:</td>
          <td>
            <input type="text" placeholder="Username" v-model="user.username" />
          </td>
        </tr>
        <tr>
          <td>Password</td>
          <td>:</td>
          <td>
            <input type="password" placeholder="Password" v-model="user.password" />
          </td>
        </tr>
        <tr>
          <td></td>
          <td></td>
          <td>
            <button class="addBtn" @click="loginNow()">Login</button>
          </td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      user: {
        username: "",
        password: ""
      }
    };
  },
  methods: {
    loginNow() {
      //console.log(this.user);
      this.$eventBus.$emit("loadingStatus", true);

      this.$axios.post(this.$apiBaseUrl + "/login", this.user).then(res => {
        this.$eventBus.$emit("loadingStatus", false);
        if (res.data.error) {
          this.$iziToast.error({
            title: "Error",
            message: res.data.message
          });
        } else {
          localStorage.setItem("token", res.data.token);
          this.$axios.defaults.headers.common["Authorization"] =
            "Token " + localStorage.getItem("token");
          this.$router.push({ name: "admin" });
        }
      });
    }
  }
};
</script>

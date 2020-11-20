<style scoped>
.body {
  margin: 0%;
  overflow: hidden;
}
.sec {
  height: 400%;
  color: white;
  text-align: justify;
  background-attachment: fixed;
  background-size: cover;
  background-repeat: no-repeat;
  background-position: center;
}
.titlelabeltop {
  font-size: 15px;
}

.titlelabelbot {
  font-size: 12px;
}
.fb-btn {
  
  color:white;
  min-width: 149px;
  background-color: #3C5898;
  height: 2.5rem;
  border-radius: .5rem;
  font-weight: 350;
  font-size: 0.85rem;


}
.gmail-btn {
  
  color:white;
  min-width: 163px;
  background-color: #e55353;
  height: 2.5rem;
  border-radius: .5rem;
  font-weight: 350;
  font-size: 0.85rem;
}

</style>
<template>
<!-- style="background-image: url(images/login/login.jpg); background-position: center; background-repeat: no-repeat;background-size:contain;" -->
<body class="body">
  <notifications group="notification" />
  <section class="sec">
    <!-- <section class="sec"> -->
    <div class="app flex-row align-items-center">
      <div class="container">
        <div class="row justify-content-center">
          <div
            class="row"
            style="background: rgb(0, 0, 0); background: rgba(0, 0, 0, 0.3);color: #f1f1f1; padding: 20px; width: 35%;"
          >
            <!-- <div
            class="row"
            
            style="background: rgb(0, 0, 0); background: black;color: #f1f1f1;padding: 20px; width: 35%; "
            >-->
            <div class="col-12">
              <h1>Login</h1>
              

              <p>Sign In to your account</p>
              <b-form @submit.prevent="authLogin()" @input="login.success = null">
                <div class="input-group mb-3">
                  <span class="input-group-addon">
                    <i class="icon-user"></i>
                  </span>
                  <b-form-input
                    ref="email"
                    v-model="login.email"
                    type="text"
                    placeholder="Email"
                  ></b-form-input>
                </div>
                <div class="input-group mb-4">
                  <b-form-invalid-feedback>
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <span v-if="login.success==false">Incorrect email or password.</span>
                  </b-form-invalid-feedback>

                  <span class="input-group-addon">
                    <i class="icon-lock"></i>
                  </span>
                  <b-form-input v-model="login.password" type="password" placeholder="Password"></b-form-input>
                </div>
                <div class="row">
                  
                 
                  <div class="col-2">
                    <b-btn :disabled="login.is_saving" type="submit" variant="primary" px-4>Login</b-btn>
                  </div>
                   <div class="col-4">
                    <b-btn  variant="secondary" px-4>Sign Up</b-btn>
                  </div>
                  <div class="col-6 text-right">
                    <button type="button" class="btn btn-link px-0">Forgot password?</button>
                  </div>
                </div>
             <hr style="width:99%;height:10px;text-align:left;margin-left:0">

              <b-btn class="fb-btn" ><i class="fa fa-facebook-official" aria-hidden="true"></i> Login with Facebook</b-btn>
              <b-btn class="gmail-btn" ><i class="fa fa-google" aria-hidden="true"></i> Login with Gmail</b-btn>
              </b-form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</body>
</template>

<script>
export default {
  name: "Login",
  data() {
    return {
      UsertypeModal: false,
      login: {
        email: null,
        password: null,
        is_saving: false
      }
    };
  },
  methods: {
    authLogin() {
      this.login.is_saving = true;
      this.$http
        .post("api/auth/login", {
          email: this.login.email,
          password: this.login.password
        })
        .then(response => {
          this.$store.commit("loginUser");
          this.$store.commit("email", response.data.email);
          localStorage.setItem("token", response.data.access_token);
          this.$notify({
            type: "success",
            group: "notification",
            title: "Success!",
            text: "User authenticated successfully."
          });
          setTimeout(
            function() {
              //client
              if (response.data.user.user_type_id == 3) {
                this.$router.push({ name: "Client" });
                return;
              }
              if (response.data.user.user_type_id == 2) {
                this.$router.push({ name: "Staff" });
                return;
              } else this.$router.push({ name: "Dashboard" });
            }.bind(this),
            1000
          );
          this.login.is_saving = false;
        })
        .catch(err => {
          this.$notify({
            type: "error",
            group: "notification",
            title: "Error!",
            text: "Incorrect email or password."
          });
          this.login.is_saving = false;
        });
    }
  },
  mounted() {
    this.focusElement("email");
  }
};
</script>

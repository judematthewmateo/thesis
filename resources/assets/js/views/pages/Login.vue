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
</style>
<template>
<!-- style="background-image: url(images/login/login.jpg); background-position: center; background-repeat: no-repeat;background-size:contain;" -->
<body class="body">
  <notifications group="notification" />
  <section class="sec" style="background-image: url(images/login/login.jpg);">
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
                    ref="username"
                    v-model="login.username"
                    type="text"
                    placeholder="Username"
                  ></b-form-input>
                </div>
                <div class="input-group mb-4">
                  <b-form-invalid-feedback>
                    <i class="fa fa-exclamation-triangle text-danger"></i>
                    <span v-if="login.success==false">Incorrect username or password.</span>
                  </b-form-invalid-feedback>

                  <span class="input-group-addon">
                    <i class="icon-lock"></i>
                  </span>
                  <b-form-input v-model="login.password" type="password" placeholder="Password"></b-form-input>
                </div>
                <div class="row">
                  <div class="col-6">
                    <b-btn :disabled="login.is_saving" type="submit" variant="primary" px-4>Login</b-btn>
                  </div>
                  <div class="col-6 text-right">
                    <button type="button" class="btn btn-link px-0">Forgot password?</button>
                  </div>
                </div>
              </b-form>
            </div>

            <!-- <div class="col-6">
              <div class="card-body text-center">
                <h2>Sign up</h2>
                <p>Create your account to enjoy the benefits of this system.</p>

                <b-button variant="primary" @click="UsertypeModal = !UsertypeModal">Register Now!</b-button>
              </div>
            </div>
          </div>
          <div>
           
            <b-modal v-model="UsertypeModal" :noCloseOnBackdrop="true">
              <div slot="modal-title" style="height:15px">
               
                <label class="titlelabel">Please choose your kind of User.</label>
                <p class="titlelabelbot">
                  <i class="fa fa-info-circle" aria-hidden="true"></i>
                  NOTE : Make sure you enter your right User Type.
                </p>
              </div>
              <div class="row justify-content-center">
                <b-button size="lg" class="m-3" variant="primary" href="/#/registerstaff">Technician</b-button>
                <b-button size="lg" class="m-3" variant="success" href="/#/registerclient">Client</b-button>
              </div>
             
              <div slot="modal-footer">
                
              </div>
            </b-modal>-->
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
        username: null,
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
          username: this.login.username,
          password: this.login.password
        })
        .then(response => {
          this.$store.commit("loginUser");
          this.$store.commit("user", response.data.user);
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
            text: "Incorrect username or password."
          });
          this.login.is_saving = false;
        });
    }
  },
  mounted() {
    this.focusElement("username");
  }
};
</script>

<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">

                        <!-- <button type="button" v-if="user.email" @click="logout">logout</button> -->
                        <div class="alert alert-danger" v-if="has_error">
                            <p>{{ error_email }}</p>
                        </div>
                        <form autocomplete="off"  @submit.prevent="login" >
                            <div class="form-group">
                                <label for="email">E-mail</label>
                                <input type="email" id="email" class="form-control" placeholder="user@example.com" v-model="form.email" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Mot de passe</label>
                                <input type="password" id="password" class="form-control" v-model="form.password" required>
                            </div>
                            <button type="submit" class="btn btn-primary">LogIn</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>

  export default {
    data() {
      return {
          form:{
              email: 'admin@test.com',
            password: 'admin'
          },
        has_error: false,
        error_email:null
      }
    },
    methods: {
      async login() {
          await this.$store.dispatch("login", this.form).catch((error) =>{
                        if (error.response) {
                            this.has_error=true;
                            this.error_email = error.response.data.errors.email[0];
                            console.log(error.response.data);
                        }
            });
            this.$router.push({ name: 'home' })
        //redirect

      }
    }
  }
</script>

<template>
<div>
    <v-card elevation="2" :loading="loading" class="mx-auto"
    max-width="344">
        <v-card-title class="text-center"
            >Iniciar sesion
        </v-card-title>
         <v-card-text>
                 <v-col cols="12">
                    <v-text-field
                        label="Usuario*"
                        v-model="form.email"
                        required
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        label="Contraseña*"
                        v-model="form.password"
                        required
                    ></v-text-field>
                </v-col>
         </v-card-text>
         <v-card-actions>
             <v-btn
                color="primary"
                text
                @click="login"
            >
                Enviar
            </v-btn>
         </v-card-actions>
    </v-card>
</div>
    <!-- <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">Login</div>
                    <div class="card-body">
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

    </div> -->
</template>
<script>

  export default {
    data() {
      return {
          loading:false,
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
          this.loading = true;
          await this.$store.dispatch("login", this.form).catch((error) =>{
                if (error.response) {
                    this.has_error=true;
                    this.error_email = error.response.data.errors.email[0];
                    console.log(error.response.data);
                }
            });
            this.loading = false;
            this.$router.push({ name: 'home' })
        //redirect

      }
    }
  }
</script>

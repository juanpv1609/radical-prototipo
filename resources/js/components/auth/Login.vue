<template>
<v-container fill-height fluid>
  <v-row align="center"
      justify="center">
      <v-col>
          <v-form
    ref="form"
    v-model="valid"
    lazy-validation
  >
    <v-card elevation="4" :loading="loading" class="mx-auto"
    max-width="344">
   <!--  <v-img
      src="https://cdn.vuetifyjs.com/images/cards/sunshine.jpg"
      height="200px"
    >
    <v-card-title
            ><h3 class="text-center"> Iniciar Sesión</h3>
        </v-card-title></v-img> -->

         <v-card-text>
             <h3 class="text-center"> Iniciar Sesión</h3>
                 <v-col cols="12">
                    <v-text-field
                        label="Usuario*"
                        v-model="form.email"
                        required type="email"
                        :rules="emailRules"
                    ></v-text-field>
                </v-col>
                <v-col cols="12">
                    <v-text-field
                        label="Contraseña*"
                        v-model="form.password"
                        required type="password"
                        :rules="passwordRules"
                        @keyup.enter="login"
                    ></v-text-field>
                </v-col>
                <v-alert v-if="has_error"
                    color="red"
                    type="error"
                    >{{error}}</v-alert>
         </v-card-text>
         <v-card-actions>
             <v-btn block
                color="primary"
                depressed
                @click="login"
            >
                Enviar
            </v-btn>
         </v-card-actions>
    </v-card>
    </v-form>
      </v-col>
  </v-row>
</v-container>


</template>
<script>

  export default {
    data() {
      return {
          valid: true,
          loading:false,
          form:{
              email: null,
            password: null
          },
        has_error: false,
        error:null,
        emailRules: [
        v => !!v || 'E-mail is required',
        v => /.+@.+\..+/.test(v) || 'E-mail must be valid',
      ],
      passwordRules: [
        v => !!v || 'Password is required',
        //v => (v && v.length >= 6) || 'Name must be less than 6 characters',
      ],
      }
    },
    methods: {
        login() {
        if (this.$refs.form.validate()) {
            this.loading = true;
          this.$store.dispatch("login", this.form).then(()=>{
               this.loading = false;
                //this.$router.push({ path: this.redirect || "/contratos" }, () => { }, () => { });
               this.$router.push({ name: 'home' }).catch(() => [])
           }).catch((error) =>{
               this.loading = false;
                if (error.response) {
                    this.has_error=true;
                    this.error = error.response.data.errors.email[0];
                }
            });

        }


        //redirect

      }
    }
  }
</script>

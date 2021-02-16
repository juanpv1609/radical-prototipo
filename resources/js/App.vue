<template >
<div>
<template v-if="$store.state.auth">
     <v-app  >
        <v-navigation-drawer  app v-model="drawer" absolute :width="200">
            <v-list-item >
                <v-list-item-content>
                    <v-list-item-title class="title">
                        TaskAPP
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list dense nav>
                <v-list-item v-for="item in items" :key="item.title" link :to="item.link">
                    <v-list-item-icon>
                        <v-icon>{{ item.icon }}</v-icon>
                    </v-list-item-icon>

                    <v-list-item-content>
                        <v-list-item-title>{{ item.title }}</v-list-item-title>
                    </v-list-item-content>
                </v-list-item>
            </v-list>
        </v-navigation-drawer >

            <v-app-bar  app color="accent-4" absolute dense dark>
                <v-app-bar-nav-icon @click="drawer = !drawer"></v-app-bar-nav-icon>


                <v-spacer></v-spacer>



                <v-menu left bottom >
                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on">
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list>
                        <v-list-item >
                            <v-list-item-title>{{ $store.state.user.email  }}</v-list-item-title
                            >
                        </v-list-item>
                        <v-spacer></v-spacer>
                        <v-list-item  @click="dialog=true; form={}">
                            <v-list-item-title> Cambiar contraseña </v-list-item-title
                            >
                        </v-list-item>
                        <v-list-item @click="logout">
                            <v-list-item-title> Salir </v-list-item-title
                            >
                        </v-list-item>
                    </v-list>
                </v-menu>
            </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>

            </v-container>
        </v-main>

        <v-footer padless>
            <!-- <v-col
            class="text-center"
            cols="12"
            >
            {{ new Date().getFullYear() }} — <strong>Vuetify</strong>
            </v-col> -->
        </v-footer>
    </v-app>
</template>
<template v-else>
<v-app >
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>

            </v-container>
        </v-main>
    </v-app></template>


    <template>
            <v-row justify="center">
                <v-dialog v-model="dialog" persistent max-width="400px" :loading="loading">
                    <v-form
                        ref="form"
                        v-model="valid"
                        lazy-validation
                    >
                    <v-card>
                        <v-card-title>
                            <span class="headline">Cambio de contraseña</span>
                        </v-card-title>
                        <v-card-text>
                            <v-container>
                                <v-alert v-if="has_error"
                                    color="red"
                                    type="error"
                                    >{{error}}</v-alert>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.old_password"
                                            label="Contraseña actual*"
                                            required
                                            type="password"
                                            :rules="[passwordRules2]"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.new_password"
                                            label="Nueva contraseña*"
                                            required
                                            type="password"
                                            :rules="[passwordRules2]"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.new_password2"
                                            label="Repita la contraseña*"
                                            required
                                            type="password"
                                            :rules="[(form.new_password===form.new_password2) || 'Las claves no coinciden']"
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            </v-container>
                            <small>*indicates required field</small>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="error"
                                text
                                @click="dialog = false"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                color="primary"
                                text
                                @click="updateClave"
                            >
                                Actualizar
                            </v-btn>
                        </v-card-actions>
                    </v-card>
                    </v-form>
                </v-dialog>
            </v-row>
        </template>
</div>
</template>

<script>
export default {
    data() {
        return {
            error:null,
            has_error:false,
            loading : false,
            valid: true,
            dialog:false,
            drawer: true,
            form:{
              old_password: null,
            new_password: null,
            new_password2: null,
          },
            items: [
                {
                    title: "Usuarios",
                    link: "/usuarios",
                    icon: "mdi-account-multiple"
                },
                { title: "Areas", link: "/areas", icon: "mdi-image" },
                { title: "Clientes", link: "/clientes", icon: "mdi-account-settings" },
                {
                    title: "Contratos",
                    link: "/contratos",
                    icon: "mdi-book"
                },
                { title: "Tareas", link: "/tareas", icon: "mdi-list-status" }
            ],
            right: null,
            passwordRules1: [
                 v => !!v || 'Password old is required',
             ],
             passwordRules2: [
                 v => !!v || 'Password new is required',
             ],
             passwordRules3: [
                 v => !!v || 'Password repeat is required'
             ]
        };
    },
    methods: {
        logout() {
            this.$swal.fire({
                title: 'Esta seguro?',
                html: `Finalizará su sesión`,
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true

                }).then(res => {
                    if (res.value) {
                        this.$store.dispatch("logout");
                        this.$router.replace("/login");
                    }
                });

        },
        updateClave(){
            if (this.$refs.form.validate()) {
                this.form.user=this.$store.state.user.id;
                console.log(this.form);
                this.loading = true;
                this.axios
                    .post('/api/usuario-updatePassword', this.form)
                    .then(response => {
                        console.log(response);
                        if (response.data==='password error!') {
                            this.has_error=true;
                            this.error='La contraseña anterior no coincide!';
                        } else {

                            this.dialog = false;
                            this.loading = false;
                            this.$store.dispatch("logout");
                        this.$router.replace("/login");
                        }
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }

        }
    }
};
</script>

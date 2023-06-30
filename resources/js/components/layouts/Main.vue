<template >
<div>
     <v-app  >
        <v-navigation-drawer  app v-model="drawer"   :width="220"
                        :mini-variant.sync="mini"   >
            <v-list-item >
                <v-list-item-content >
                    <v-list-item-title class="title">
                        <v-img src="../img/nuevologo-radical.png" alt="Logo"  ></v-img>
                    </v-list-item-title>
                </v-list-item-content>
            </v-list-item>

            <v-list dense nav>
                <div v-for="item in items" :key="item.title">
                    <v-list-item v-if="!item.subLinks" link :to="item.link"
                     color="orange darken-4">
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>

                    <v-list-group v-else-if="(item.subLinks)"  :key="item.title"
                        no-action :prepend-icon="item.icon" color="orange darken-4">
                        <template v-slot:activator >
                                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                         </template>
                         <v-list-item v-for="sublink in item.subLinks"
                                        :key="sublink.title"
                                     link :to="sublink.link">

                                <v-list-item-title>
                                    {{ sublink.title }}</v-list-item-title>
                                    <v-list-item-icon>
                                    <v-icon v-text="sublink.icon"></v-icon>
                                    </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>

                </div>
                <div v-for="item in itemsAdmin" :key="item.title" >

                    <v-list-group v-if="$store.state.user.role==2"  :key="item.title"
                        no-action :prepend-icon="item.icon" color="orange darken-4">
                        <template v-slot:activator >
                                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                         </template>
                         <v-list-item v-for="sublink in item.subLinks"
                                        :key="sublink.title"
                                     link :to="sublink.link">

                                <v-list-item-title>
                                    {{ sublink.title }}</v-list-item-title>
                                    <v-list-item-icon>
                                    <v-icon v-text="sublink.icon"></v-icon>
                                    </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>

                </div>
                <v-divider></v-divider>
                <div v-for="item in itemsPersonal" :key="item.title">
                    <v-list-item v-if="!item.subLinks" link :to="item.link"
                    :disabled="(item.isAdmin)" color="orange darken-4">
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-group v-else-if="(item.subLinks) && (!item.isAdmin)"  :key="item.title"
                        no-action :prepend-icon="item.icon" color="orange darken-4">
                        <template v-slot:activator >
                                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                         </template>
                         <v-list-item v-for="sublink in item.subLinks"
                                        :key="sublink.title"
                                     link :to="sublink.link">

                                <v-list-item-title>
                                    {{ sublink.title }}</v-list-item-title>
                                    <v-list-item-icon>
                                    <v-icon v-text="sublink.icon"></v-icon>
                                    </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>

                </div>
                <div v-for="item in itemsAdminPersonal" :key="item.title" >

                    <v-list-group v-if="$store.state.user.role==2"  :key="item.title"
                        no-action :prepend-icon="item.icon" color="orange darken-4">
                        <template v-slot:activator >
                                    <v-list-item-title>{{ item.title }}</v-list-item-title>
                         </template>
                         <v-list-item v-for="sublink in item.subLinks"
                                        :key="sublink.title"
                                     link :to="sublink.link">

                                <v-list-item-title>
                                    {{ sublink.title }}</v-list-item-title>
                                    <v-list-item-icon>
                                    <v-icon v-text="sublink.icon"></v-icon>
                                    </v-list-item-icon>
                        </v-list-item>
                    </v-list-group>

                </div>

            </v-list>

            <!-- <template v-slot:append>
                <div class="pa-2">
                <v-btn block dense dark @click="logout">
                    Salir
                </v-btn>
                </div>
            </template> -->
        </v-navigation-drawer >

            <v-app-bar  app color="accent-4" absolute dense dark>
                <v-app-bar-nav-icon @click.stop="mini = !mini"></v-app-bar-nav-icon>


                <v-spacer></v-spacer>
                <v-spacer ></v-spacer>
                <v-icon small>mdi-account-circle</v-icon><span> {{$store.state.user.name}}</span>

                <v-menu left bottom >

                    <template v-slot:activator="{ on, attrs }">
                        <v-btn icon v-bind="attrs" v-on="on" >
                            <v-icon>mdi-dots-vertical</v-icon>
                        </v-btn>
                    </template>

                    <v-list dense max-width="300px">
                        <v-list-item>
                            <v-list-item-avatar>
                                <v-icon x-large>mdi-account-circle</v-icon>
                                </v-list-item-avatar>
                            <v-list-item-content>
                            <v-list-item-title>
                            {{ $store.state.user.name }}
                            </v-list-item-title>
                            <v-list-item-subtitle>
                                {{ $store.state.user.email }} <br>
                                {{ ($store.state.user.role==2) ? 'ADMINISTRADOR' : 'CONSULTA' }}
                                

                            </v-list-item-subtitle>
                            </v-list-item-content>

                        </v-list-item>
                        <v-list-item>
                            <v-btn block small @click=" dialog = true;form = {};" text link color="primary">
                                   <v-icon small>mdi-key</v-icon> Cambiar contraseña</v-btn>
                        </v-list-item>
                        <v-list-item>
                                    <v-btn block small @click="logout" text color="red"><v-icon small>mdi-logout</v-icon>
                                    Salir</v-btn>
                        </v-list-item>



                    </v-list>
                </v-menu>
            </v-app-bar>

        <!-- Sizes your content based upon application components -->
        <v-main style="background:#F5F5F5;" >
            <!-- Provides the application the proper gutter -->
            <v-container fluid >
                <!-- If using vue-router -->
                <router-view></router-view>

            </v-container>
        </v-main>
        <!-- <v-footer dense app fixed flat padless
        >
        <v-col cols="4" class="text-left">
                <router-link to="/"> Acerca de</router-link>

            </v-col>
            <v-col
            class="text-center"
            cols="4"
            ><a href="https://www.gruporadical.com/" target="_blank">Grupo Radical</a>
            &copy;{{ new Date().getFullYear() }}. Todos los derechos reservados
            </v-col>
            <v-col
            class="text-end"
            cols="4"
            >Version 1.0
            </v-col>
        </v-footer> -->
    </v-app>
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
                                <v-alert v-if="has_error"
                                    color="red"
                                    type="error"
                                    >{{error}}</v-alert>
                                <v-row dense>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.old_password"
                                            label="Contraseña actual*"
                                            required
                                            type="password"
                                            :rules="[passwordRules2]"
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.new_password"
                                            label="Nueva contraseña*"
                                            required
                                            type="password"
                                            :rules="[passwordRules2]"
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                                <v-row dense>
                                    <v-col cols="12">
                                        <v-text-field
                                            v-model="form.new_password2"
                                            label="Repita la contraseña*"
                                            required
                                            type="password"
                                            :rules="[(form.new_password===form.new_password2) || 'Las claves no coinciden']"
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                </v-row>
                            <small>*indicates required field</small>
                        </v-card-text>
                        <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn
                                color="red"
                                text
                                @click="dialog = false"
                            >
                                Cerrar
                            </v-btn>
                            <v-btn
                                color="blue"
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
    data(){
        return {
            mini:true,
            dialog:false,
            drawer: true,
            form:{
            old_password: null,
            new_password: null,
            new_password2: null,

          },
          error:null,
            has_error:false,
            loading : false,
            valid: true,
            passwordRules1: [
                 v => !!v || 'Password old is required',
             ],
             passwordRules2: [
                 v => !!v || 'Password new is required',
             ],
             passwordRules3: [
                 v => !!v || 'Password repeat is required'
             ],
            items: [


                { title: "Clientes",link: "/clientes", icon: "mdi-card-account-details", },

                {
                    title: "Contratos",
                    link: "/contratos",
                    icon: "mdi-book"
                },
                { title: "Entregables", icon: "mdi-send-check",
                        subLinks: [
                                { title: "General",  link: "/all-tareas", icon: "mdi-list-status"},
                                { title:  "Por Cliente", link: "/tareas", icon: "mdi-card-account-details-star"},

                            ],
                     },
                {
                    title: "Reportes",
                    icon: "mdi-chart-bar",
                    subLinks: [
                        { title: "Entregables", link: "/reporte-tareas", icon: "mdi-check"},
                        { title: "Por Contrato", link: "/reporte-contratos", icon: "mdi-checkbox-marked"},
                        { title: "Por Usuario", link: "/reporte-usuario", icon: "mdi-account-check"},
                        { title: "Contratos", link: "/reporte-allContratos", icon: "mdi-notebook-check"},

                    ],
                },

            ],
            itemsAdmin:[
                {
                    title: "Administrar",
                    icon: "mdi-cogs",
                    subLinks: [
                        { title: "Usuarios", link: "/usuarios", icon: "mdi-account-multiple"},
                         { title: "Areas", link: "/areas", icon: "mdi-view-quilt" },
                         { title: "Servicios", link: "/servicios", icon: "mdi-toolbox-outline" },
                         { title: "Marca/Fabricante", link: "/marcas", icon: "mdi-toolbox-outline" },
                        { title: "Tipo Tareas", link: "/tipo-tareas", icon: "mdi-ballot" },
                        { title: "Frecuencias", link: "/frecuencias", icon: "mdi-clock-fast" },
                        { title: "Paises", link: "/paises", icon: "mdi-earth" },
                        { title: "Casos de Uso", link: "/casos-de-uso", icon: "mdi-sitemap" },
                        { title: "Destinatarios", link: "/destinatarios", icon: "mdi-account-multiple"},

                    ],
                },
            ],
            itemsPersonal:[
                /*{ title: "Personal", link: "/personal", icon: "mdi-face-agent" },
                {
                    title: "Reportes Per.",
                    icon: "mdi-chart-bar",
                    subLinks: [

                        {       
                            title: "Certificacion", link: "/reporte-certificacion",icon: "mdi-certificate"
                        },
                        {
                            title: "Persona",  link: "/reporte-persona",icon: "mdi-card-account-details"
                        }
                    ],
                },*/

            ],
            itemsAdminPersonal:[
                /*{
                    title: "Administrar Per.",
                    icon: "mdi-cogs",
                    subLinks: [

                        { title: "Perfil Laboral", link: "/perfil-puesto", icon: "mdi-sitemap" },
                        {
                            title: "Certificaciones",
                            link: "/certificaciones",
                            icon: "mdi-certificate"
                        },
                        {
                            title: "Niveles Estudio",
                            link: "/nivel-estudio",
                            icon: "mdi-graph-outline"
                        }
                    ],
                },*/
            ],

            right: null,
        }
    },
    methods:{
        logout() {
            this.$swal.fire({
                title: 'Esta seguro?',
                html: `Finalizará su sesión`,
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true

                }).then(res => {
                    if (res.value) {
                        this.$store.dispatch("logout").then(()=>{
                            this.$router.push({ name: 'login' })
                        }).catch(() => [])
                        //this.$router.replace("/login");
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
                            this.$store.dispatch("logout").then(()=>{

                                this.$router.replace("/login");
                            })
                        }
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }

        }
    }
}
</script>

<template >
     <v-app v-if="$store.state.auth">
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
                        <v-list-item >
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
    <v-app v-else>
        <v-main>
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>

            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {
    data() {
        return {
            drawer: true,
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
            right: null
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

        }
    }
};
</script>

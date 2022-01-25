<template >
<v-app >
        <v-main style="background:#F5F5F5;">
            <!-- Provides the application the proper gutter -->
            <v-container fluid>
                <!-- If using vue-router -->
                <router-view></router-view>

            </v-container>
        </v-main>
        <v-footer dense app fixed flat padless
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
            >Version 2.0
            </v-col>
        </v-footer>
    </v-app>
</template>

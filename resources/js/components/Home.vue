<template>
    <v-container fill-height fluid>
        <v-row align="center" justify="center">
            <v-col>
                <v-card elevation="4" class="mx-auto">
                    <v-card-title
                        class="d-flex justify-space-between"
                    >&nbsp;
                        <v-btn
                            v-if="!$store.state.auth"
                            class="mx-2"
                            dark
                            color="primary"
                            link
                            :to="'/login'"
                            >Iniciar Sesión
                        </v-btn>
                    </v-card-title>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" sm="4">
                                <v-img
                                    src="../img/nuevologo-radical.png"
                                    alt="Logo"
                                ></v-img>
                            </v-col>
                            <v-col cols="12" sm="8">
                                <h3>RGSDM (Radical Gestión SDM)</h3>
                                <p>
                                    Sistema de gestión automatizada de alertas,
                                    software web destinado a la automatización y
                                    gestión de tareas y asignación
                                    responsabilidades al personal que participan
                                    en un contrato.
                                </p>
                                Version 1.0
                                <a
                                    href="https://www.gruporadical.com/"
                                    target="_blank"
                                    >Grupo Radical</a
                                >
                                &copy;{{ new Date().getFullYear() }}. Todos los
                                derechos reservados
                            </v-col>
                        </v-row>
                        <v-row >
                            <v-col cols="12" >
                                <v-carousel
                                    cycle
                                    height="400"
                                    hide-delimiter-background
                                    show-arrows-on-hover
                                >
                                    <v-carousel-item
                                    v-for="(slide, i) in slides"
                                    :key="i"
                                    >
                                    <v-sheet
                                        :color="colors[i]"
                                        height="100%"
                                        elevation="4"
                                        :class="`rounded-lg`"
                                    >
                                        <v-row
                                        class="fill-height"
                                        align="center"
                                        justify="center"
                                        >
                                        <div class="text-center">
                                            <h3 class="display-3">
                                                <v-icon x-large style="font-size:50px">
                                                    {{ slide.icon }}
                                                </v-icon>
                                                    {{ slide.title }}
                                            </h3>
                                            <p>
                                                {{ slide.subtitle }}
                                            </p>
                                            <v-btn color="dark"
                                                    link :to="slide.link" >
                                                Ir
                                            </v-btn>
                                        </div>

                                        </v-row>
                                    </v-sheet>
                                    </v-carousel-item>
                                </v-carousel>

                            </v-col>
                           <!--  <v-col cols="12" sm="6">
                                <h5>Accesos directos:</h5>
                                <v-row>
                                    <v-col cols="12" sm="6">
                                        <v-hover>
                                            <template v-slot:default="{ hover }">
                                            <v-card
                                                class="mx-auto"
                                                color="blue"
                                                dark
                                            >


                                                <v-card-text>
                                                    <v-icon x-large style="font-size:50px">mdi-account-multiple</v-icon>
                                                <h2 class="title">
                                                    Usuarios
                                                </h2>
                                                </v-card-text>



                                                <v-fade-transition>
                                                <v-overlay
                                                    v-if="hover"
                                                    absolute
                                                    color="#036358"
                                                >
                                                    <v-btn  class="mx-2"

                                                        link
                                                        :to="'/login'">Ver usuarios</v-btn>
                                                </v-overlay>
                                                </v-fade-transition>
                                            </v-card>
                                            </template>
                                        </v-hover>
                                    </v-col>
                                     <v-col cols="12" sm="6">

                                    </v-col>
                                </v-row>
                                <v-row>
                                    <v-col cols="12" sm="6">

                                    </v-col>
                                     <v-col cols="12" sm="6">

                                    </v-col>
                                </v-row>
                            </v-col> -->
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>

  export default {
    data() {
      return {
          overlay: false,
          slides: [
                {
                    title: 'Gestión de usuarios',
                    subtitle: 'Sesiones, seguridad, roles',
                    icon:'mdi-account-multiple',
                    link: '/usuarios'
                },
                {
                    title: 'Gestión de clientes',
                    subtitle: 'Información de contacto',
                    icon:'mdi-face',
                    link: '/clientes'
                },
                {
                    title: 'Creación de contratos',
                    subtitle: 'Fechas plazo, archivos adjuntos, etc.',
                    icon:'mdi-book',
                    link: '/contratos'
                },
                {
                    title: 'Creación automatica de tareas',
                    subtitle: 'Fechas plazo, responsables, tipo de tarea, entregable, etc.',
                    icon:'mdi-format-list-checks',
                    link: '/contratos'
                },
                {
                    title: 'Modificación de tareas',
                    subtitle: 'Cambio de estado, adjuntar documentos.',
                    icon:'mdi-pencil',
                    link: '/tareas'
                },
                {
                    title: 'Notificaciones automaticas',
                    subtitle: 'Depende de la fecha de entrega, disparo automático gestionable.',
                    icon:'mdi-bell',
                    link: ''
                },
                {
                    title: 'Emisión de reportes',
                    subtitle: 'Rango de fechas, responsables, tareas pendientes, terminadas, etc.',
                    icon:'mdi-chart-bar',
                    link: '/reporte-tareas'
                }
          ],
          colors: [
          'light-blue lighten-3',
          'light-green lighten-3',
          'orange lighten-3',
          'teal lighten-3',
          'deep-purple lighten-3',
          'red lighten-3',
          'deep-orange lighten-3'
        ],
      }
    }
  }

  </script>

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
                                <v-carousel
                                    cycle
                                    height="300"
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
                                        elevation="12"
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
          'indigo',
          'warning',
          'pink darken-2',
          'red lighten-1',
          'deep-purple accent-4',
          'blue',
          'green'
        ],
      }
    }
  }

  </script>

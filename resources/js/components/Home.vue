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
                        <v-row class="pl-4">
                            <v-col cols="12" sm="6">
                                <h5>Sus principales caracteristicas:</h5>
                                <v-list>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-account-multiple</v-icon>Gestión de
                                                usuarios</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Sesiones, seguridad,
                                                roles</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-face</v-icon>Gestión de
                                                clientes</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Información de
                                                contacto</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-book</v-icon>Creación de
                                                contratos</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Fechas plazo, archivos
                                                adjuntos,
                                                etc.</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-format-list-checks</v-icon>Cración automatica de
                                                tareas</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Fechas plazo, responsables,
                                                tipo de tarea, entregable,
                                                etc.</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-pencil</v-icon>Modificación de
                                                tareas</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Cambio de estado, adjuntar
                                                documentos.</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-bell</v-icon>Notidicaciones automaticas
                                                mediante correo
                                                electronico</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Depende de la fecha de entrega,
                                                disparo automático
                                                gestionable.</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                ><v-icon>mdi-chart-bar</v-icon>Emisión de
                                                reportes</v-list-item-title
                                            >
                                            <v-list-item-subtitle
                                                >Rango de fechas, responsables,
                                                tareas pendientes, terminadas,
                                                etc.</v-list-item-subtitle
                                            >
                                        </v-list-item-content>
                                    </v-list-item>
                                </v-list>
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
      }
    }
  }

  </script>

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
                        <v-row>
                            <v-col cols="12" sm="6">
                                <h5>Sus principales caracteristicas:</h5>
                                <v-list>
                                    <v-list-item>
                                        <v-list-item-content>
                                            <v-list-item-title
                                                >Gestión de
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
                                                >Gestión de
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
                                                >Creación de
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
                                                >Cración automatica de
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
                                                >Modificación de
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
                                                >Notidicaciones automaticas
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
                                                >Emisión de
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
                        </v-row>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>

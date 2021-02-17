<template>
   <v-container fill-height fluid>
  <v-row align="center"
      justify="center">
      <v-col>
          <v-card elevation="4"  class="mx-auto">
              <v-card-title class="d-flex justify-space-between display-2">Bienvenido
                      <v-btn v-if="!$store.state.auth"
                        class="mx-2"
                        dark
                        color="primary"
                        link
                        :to="'/login'"
                    >Iniciar Sesión
                    </v-btn>
              </v-card-title>
              <v-card-text>
                  <p >Sistema de alertas automáticas, este sistema permitirá la creación, edición, eliminación de: clientes, contratos, usuarios, tareas,
                       generacion automática de tareas mediante un algoritmo automatizado, podrá adjuntar archivos a las tareas terminadas.</p>
                       <p>Cuenta con un notificador automático de tareas y entregas pendientes mediante correo electrónico.</p>
              </v-card-text>
          </v-card>
      </v-col>
  </v-row>
   </v-container>

</template>

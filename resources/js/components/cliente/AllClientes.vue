<template>
<div>
            <v-card elevation="2" :loading="loading">
                <v-card-title
          >
           <v-badge
                :content="clientes.length"
                :value="clientes.length"
                color="green"

            >
            Clientes
            </v-badge>
          <v-spacer></v-spacer>
          <v-col cols="auto">
              <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Buscar"
              single-line
              hide-details
              filled
            rounded
            dense
          ></v-text-field>
          </v-col>

          <v-btn
              class="mx-2"
              fab
              dark
              small
              color="primary"
              @click="addClient"
          >
              <v-icon dark>
                  mdi-plus
              </v-icon>
          </v-btn>
        </v-card-title>

                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="clientes"
                        :search="search"
                    >
                    <template v-slot:item="row">
                        <tr>
                            <td>{{row.item.razon_social}}</td>
                            <td>{{row.item.nombre_comercial}}</td>
                            <td>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon small v-bind="attrs"
                                            v-on="on" >
                                            <v-icon >mdi-email</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.correo }}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon small v-bind="attrs"
                                            v-on="on" >
                                            <v-icon >mdi-phone</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.telefono }}</span>
                                </v-tooltip>
                                <v-tooltip bottom>
                                    <template v-slot:activator="{ on, attrs }">
                                        <v-btn  icon small v-bind="attrs"
                                            v-on="on" >
                                            <v-icon >mdi-map-marker</v-icon>
                                        </v-btn>
                                    </template>
                                    <span>{{ row.item.direccion }}</span>
                                </v-tooltip>
                            </td>
                            <td>
                                <v-btn  icon color="primary" :disabled="$store.state.user.role==1" @click="editClient(row.item)">
                                    <v-icon dark>mdi-pencil</v-icon>
                                    </v-btn>
                                    <v-btn  icon color="error" :disabled="$store.state.user.role==1" @click="deleteClient(row.item)">
                                    <v-icon dark>mdi-delete</v-icon>
                                </v-btn>
                            </td>
                        </tr>
                    </template>
        </v-data-table>
                </v-card-text>

                <v-card-actions> </v-card-actions>
            </v-card>
            <template>
                <v-row justify="center">
                    <v-dialog v-model="dialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ titleForm }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-select :items="tipo_identificacion"
                                            v-model="cliente.tipo_identificacion"
                                                label="Tipo de identificacion" >
                                                <template slot="selection" slot-scope="data">
                                                    <!-- HTML that describe how select should render selected items -->
                                                    {{ data.item.nombre }}
                                                </template>
                                                <template slot="item" slot-scope="data">
                                                    <!-- HTML that describe how select should render items when the select is open -->
                                                    {{ data.item.nombre }}
                                                </template>
                                            </v-select>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="cliente.dni"
                                                label="Numero de identificacion*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                     <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="cliente.razon_social"
                                                label="Razon social*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="cliente.nombre_comercial"
                                                label="Nombre comercial*"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="cliente.correo"
                                                label="Correo electronico"
                                                required
                                            ></v-text-field>
                                        </v-col>
                                        <v-col cols="6">
                                            <v-text-field
                                                v-model="cliente.telefono"
                                                label="Telefono"

                                            ></v-text-field>
                                        </v-col>
                                    </v-row>
                                    <v-row>
                                        <v-col cols="12">
                                            <v-text-field
                                                v-model="cliente.direccion"
                                                label="Direccion"

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
                                    v-if="!update"
                                    color="primary"
                                    text
                                    @click="createClient"
                                >
                                    Guardar
                                </v-btn>
                                <v-btn
                                    v-else
                                    color="primary"
                                    text
                                    @click="updateClient"
                                >
                                    Actualizar
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                </v-row>
            </template>
</div>


</template>

<script>
    export default {
        data() {
            return {
                clientes: [],
                tipo_identificacion: {},
                dialog: false,
                update: false,
                cliente: {},
                loading: true,
                titleForm: null,
                search: "",
                headers: [
                { text: "Razon Social", value: "razon_social" },
                { text: "Nombre Comercial", value: "nombre_comercial" },
                { text: "Contacto", value: "contacto" },
                { text: "Acciones", value: "controls", sortable: false }
            ]

            }
        },
        created() {
            this.axios
                .get('/api/clientes')
                .then(response => {
                    this.clientes = response.data;
                    this.loading = false;
                });
            this.axios
                .get('/api/tipo-identificacion')
                .then(response => {
                    console.log(response.data);
                    this.tipo_identificacion = response.data;
                });
        },
        methods: {
            addClient() {

                this.titleForm = "Nuevo Cliente";
                this.cliente = {};
                this.update = false;
                this.dialog = true;
            },
            editClient(el) {
                this.titleForm = "Editar Cliente";
                this.update = true;
                this.cliente.id = el.id;
                this.cliente.tipo_identificacion = el.tipo_identificacion;
                this.cliente.dni = el.dni;
                this.cliente.razon_social = el.razon_social;
                this.cliente.nombre_comercial = el.nombre_comercial;
                this.cliente.correo = el.correo;
                this.cliente.telefono = el.telefono;
                this.cliente.direccion = el.direccion;
                this.dialog = true;
            },
            createClient() {
                this.loading = true;
                this.cliente.tipo_identificacion=this.cliente.tipo_identificacion.id;
                 this.axios
                    .post('/api/clientes', this.cliente)
                    .then(() => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/clientes')
                            .then(response => {
                                this.clientes = response.data;
                            });
                    })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
            updateClient() {
                this.loading = true;
                this.cliente.tipo_identificacion=this.cliente.tipo_identificacion.id;

                this.axios
                    .patch(`/api/clientes/${this.cliente.id}`, this.cliente)
                    .then((res) => {
                        this.dialog = false;
                        this.loading = false;
                        this.axios
                            .get('/api/clientes')
                            .then(response => {
                                this.clientes = response.data;
                            });
                    });
            },
            deleteClient(el) {
                this.loading = true;
                this.axios
                    .delete(`/api/clientes/${el.id}`)
                    .then(response => {
                        let i = this.clientes.map(data => data.id).indexOf(el.id);
                        this.clientes.splice(i, 1)
                        this.loading = false;
                    });
            }
        }
    }
</script>

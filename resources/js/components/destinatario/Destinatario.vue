
<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title>

                <v-badge :content="destinatarios.length" :value="destinatarios.length" color="green">
                    Destinatarios
                </v-badge>

                <v-spacer></v-spacer>

                <v-col cols="auto">
                    <v-text-field v-model="search" append-icon="mdi-magnify" label="Buscar" single-line hide-details filled
                        rounded dense></v-text-field>
                </v-col>

                <v-btn class="mx-2" fab dark small color="primary" @click="addDestinatario">
                    <v-icon dark>mdi-plus</v-icon>

                </v-btn>

            </v-card-title>



            <v-card-text>

                <v-data-table :headers="headers" :items="destinatarios" :search="search">
                    <template v-slot:item="row">
                        <tr>

                            <td>{{ row.item.id }}</td>
                            <td>{{ row.item.name }}</td>
                            <td>{{ row.item.email }}</td>
                            <td>
                                <v-btn icon color="primary" @click="$event => editDestinatario(row.item)">

                                    <v-icon dark>mdi-pencil</v-icon>

                                </v-btn>

                                <v-btn icon color="error" @click="$event => deleteDestinatario(row.item)">

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

                <v-dialog v-model="dialog" persistent max-width="400px">
                    
                    <v-card>

                        <v-card-title>

                            <span class="headline">{{ titleForm }}</span>

                        </v-card-title>

                        <v-card-text>

                            <v-container>

                                <v-row>

                                    <v-col cols="12">

                                        <v-text-field v-model="destinatario.name" label="Nombre del destinatario*"
                                            required></v-text-field>

                                    </v-col>

                                </v-row>

                                <v-row>

                                    <v-col cols="12">

                                        <v-text-field v-model="destinatario.email" label="Correo del destinatario*"
                                            required></v-text-field>

                                    </v-col>

                                </v-row>

                            </v-container>

                            <small>*indicates required field</small>

                        </v-card-text>

                        <v-card-actions>

                            <v-spacer></v-spacer>

                            <v-btn color="error" text @click="$event => dialog = false">
                                Cancel
                            </v-btn>

                            <v-btn v-if="!update" color="primary" text @click="createDestinatario">
                                Guardar
                            </v-btn>

                            <v-btn v-else color="primary" text @click="updateDestinatario">
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
            destinatarios: [],
            destinatario: {},
            dialog: false,
            update: false,
            loading: false,
            titleForm: null,
            search: "",
            headers: [
                {
                    text: "Id",
                    value: "id"
                },
                {
                    text: "Nombre",
                    value: "name"
                },
                {
                    text: "Correo",
                    value: "email"
                },
                {
                    text: "Acciones",
                    sortable: false
                }
            ]

        }
    },

    created(){

        this.axios.get("/api/destinatarios/").then(response => {
            this.destinatarios = response.data;
            console.log(response.data)
            this.loading = false;
        });
    },

    methods: {

        createDestinatario() {

            this.loading = true
            this.axios
                .post("/api/destinatarios", this.destinatario)
                .then(() => {
                    this.dialog = false
                    this.axios.get("/api/destinatarios/"). then(response => {
                        this.destinatarios = response.data
                        this.loading = false;
                    })
                })

                .catch(err => console.log(err))
                .finally(() => (this.loading = false))

        },


        addDestinatario() {

            this.titleForm = "Nuevo Destinatario";
            this.destinatario = {};
            this.update = false;
            this.dialog = true;
        },

        editDestinatario(el) {
            this.titleForm = "Editar Destinatario"
            this.update =true
            this.destinatario.id = el.id
            this.destinatario.name = el.name
            this.destinatario.email = el.email
            this.dialog = true
        },

        deleteDestinatario(el) {
            this.loading = true
            this.axios.delete(`/api/destinatarios/${el.id}`).then (() => {
                let i = this.destinatarios.map(data => data.id). indexOf (el.id)
                this.destinatarios.splice(i,1);
                this.loading = false
            })
        },

        updateDestinatario() {
            this.loading = true
            this.axios.patch(`/api/destinatarios/${this.destinatario.id}`, this.destinatario)
            .then(res => {
                this.dialog = false
                this.axios.get("/api/destinatarios/").then(response => {
                    this.destinatarios = response.data;
                    this.loading = false;
                })
            })
        },
        
    }
}
</script>



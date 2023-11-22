<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6">
                <span>Notificar 1era alerta de entregables</span>
            </v-card-title>
            <v-card-text>
                <v-col cols="3">
                    <v-btn block color="primary" dark @click="sendMails">
                        <v-icon>mdi-email</v-icon>
                        <span class="ml-5">Enviar Notificaciones</span>
                    </v-btn>
                </v-col>
            </v-card-text>
            <v-card-text>
                <v-skeleton-loader v-if="firstLoad" :loading="loading" type="table"></v-skeleton-loader>
                <v-data-table :headers="headers" :items="tareas" v-show="!firstLoad" sort-by="fecha">
                    <template v-slot:item="row">
                        <tr>
                            <td>{{ row.item.ticket }}</td>
                            <td>{{ row.item.contrato.observacion }}</td>
                            <td>{{ row.item.fecha }}</td>
                            <td>{{ row.item.usuario.name }}</td>
                            <td>{{ row.item.descripcion }}</td>

                        </tr>
                    </template>
                </v-data-table>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            firstLoad: false,
            tareas: [],
            headers: [
                { text: "Ticket", value: "ticket", groupable: false },
                { text: "Proyecto", value: "contrato.observacion", groupable: false },
                { text: "Fecha entrega", value: "fecha", groupable: false },
                { text: "Responsable", value: "usuario.name", groupable: false },
                { text: "Entregable", value: "descripcion", groupable: false },

            ],
        }
    },
    created() {
        /*Generar las tareas por el API*/
        this.axios
            .get("/api/notificarTareas")
            .then(response => {
                this.tareas = response.data;
                console.log(this.tareas)
            })
    },
    methods: {

        async sendMails() {



            try {
                await this.$swal.fire({
                    title: '¿Está seguro?',
                    html: 'Se enviarán las notificaciones de alerta de tareas...',
                    icon: 'question',
                    showConfirmButton: true,
                    showCancelButton: true,
                });

                this.$swal.fire({
                    title: 'Espere',
                    text: 'Enviando notificaciones...',
                    icon: 'info',
                    allowOutsideClick: false,
                    showCancelButton: false,
                    showConfirmButton: false,
                    showCloseButton: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                });

                const response = await this.axios.get(`/api/sendAlertTareas`);

                const settledPromises = await Promise.allSettled(response.data);

                const failures = settledPromises.filter((result) => result.status === 'rejected');

                if (failures.length > 0) {
                    console.error('Errores en el envío de correos:', failures);

                    this.$swal.fire({
                        title: 'Fallo',
                        html: 'Algunos correos no se pudieron enviar correctamente.',
                        icon: 'error',
                        showCloseButton: true,
                        allowOutsideClick: true,
                    });
                } else {
                    this.$swal.fire({
                        title: 'Correcto',
                        text: 'Todos los correos se enviaron correctamente',
                        icon: 'success',
                        showCloseButton: true,
                        allowOutsideClick: true,
                    });
                }
            } catch (error) {
                console.error('Error enviando correos:', error);

                this.$swal.fire({
                    title: 'Fallo',
                    text: 'El proceso de notificación falló',
                    icon: 'error',
                    showCloseButton: true,
                    allowOutsideClick: true,
                });
            }
        },

    }
}
</script>

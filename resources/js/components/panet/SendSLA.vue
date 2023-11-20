<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6">
                <span>Notificar plazo de cierre de tickets</span>
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-col cols="3">
                            <v-select ref="prioritySelect" :items="priorities" label="Seleccione una prioridad"
                                @input="fetchIncidents">
                                <template slot="selection" slot-scope="data">
                                    {{ data.item.text }}
                                </template>
                                <template slot="item" slot-scope="data">
                                    {{ data.item.text }}
                                </template>
                                <template slot="selection" slot-scope="data">
                                    {{ data.item.text }}
                                </template>
                                <template slot="item" slot-scope="data">
                                    {{ data.item.text }}
                                </template>
                            </v-select>
                        </v-col>
                        <v-col class="ml-auto" cols="3">
                            <v-btn  block color="primary" dark  @click="sendMails">
                                <v-icon>mdi-email</v-icon>
                                <span class="ml-5">Enviar Notificaciones</span>
                            </v-btn>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
            <v-card-text>
                <v-data-table :headers="headers" :items="incidents">
                    <template v-slot:item.creationDate="{ item }">
                        {{ (new Date(item.creationDate)).toLocaleDateString('en-US') }}
                    </template>
                    <template v-slot:item.status="{ item }">
                        <v-chip :color="item.status == 'New' ? 'green' : 'red'" dark>
                            {{ item.status }}
                        </v-chip>
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
            incidents: [],
            contrato: {},
            loading: false,
            priorities: [
                { text: 'Baja', value: 'Baja' },
                { text: 'Media', value: 'Media' },
                { text: 'Alta', value: 'Alta' },
                { text: 'Crítica', value: 'Critica' }
            ],
            headers: [
                { text: "Código", value: "code" },
                { text: "Estado", value: 'status' },
                { text: "Fecha Creación", value: 'creationDate' },
                { text: "Titulo", value: 'title' },
                { text: "Descripción", value: 'description' },
            ],

        }
    },
    methods: {
        fetchIncidents() {
            this.$nextTick(() => {
                const selectedPriority = this.$refs.prioritySelect.selectedItems[0].value; // Get the selected priority value

                // Check if a priority is selected
                if (selectedPriority) {
                    this.loading = true; // Set loading indicator to true

                    this.$nextTick(() => {
                        this.axios
                            .get(`/api/cierreTicket/${selectedPriority}`)
                            .then((response) => {
                                this.incidents = response.data;
                                //console.log(this.incidents);

                                this.loading = false; // Reset loading indicator after data is fetched
                            });
                    });
                } else {
                    // Do not make API call if no priority is selected
                    return;
                }
            });
        },
        async sendMails() {
            const selectedPriority = this.$refs.prioritySelect.selectedItems[0]?.value;

            if (!selectedPriority) {
                this.$swal.fire({
                    title: 'Prioridad no seleccionada',
                    text: 'Debe seleccionar una prioridad antes de enviar las notificaciones.',
                    icon: 'error',
                    showCloseButton: true,
                    allowOutsideClick: true,
                });
                return;
            }

            try {
                await this.$swal.fire({
                    title: '¿Está seguro?',
                    html: 'Se enviarán las notificaciones del plazo al cierre de los tickets',
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

                const response = await this.axios.get(`/api/notificarTicketPorCerrar/${selectedPriority}`);

                const settledPromises = await Promise.allSettled(response.data);

                const failures = settledPromises.filter((result) => result.status === 'rejected');

                if (failures.length > 0) {
                    console.error('Errores en el envío de correos:', failures);

                    this.$swal.fire({
                        title: 'Fallo',
                        html: 'Algunos correos no se pudieron enviar correctamente. Consulta la consola para obtener más detalles.',
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

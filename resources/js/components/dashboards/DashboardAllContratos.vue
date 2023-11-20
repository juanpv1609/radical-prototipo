
<template>
    <div>
        <v-card elevation="2" class="mb-2">
            <v-card-title class="d-flex justify-space-between mb-6">
                Gráficos de contratos por cliente
            </v-card-title>
            <v-card-text>
                <v-form>
                    <v-row>
                        <v-col cols="2">
                            <v-select clearable clear-icon="mdi-close-circle" :items="clientes" v-model="cliente"
                                item-text="nombre_comercial" item-value="id" label="Seleccione un cliente"
                                @input="verContratos">
                            </v-select>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
        <v-col cols="4">
                        <!--<v-card>
                            <v-card-title>
                                Tiempo por tipo de actividad
                            </v-card-title>
                            <v-card-text>
                                <GChart type="PieChart" :data="chartData" :options="chartOptions" :width="400" :height="300" />
                            </v-card-text>
                        </v-card>
                        -->
                    </v-col>


    </div>
</template>

<script>
export default {
    /*components: {
        GChart
    },*/
    data() {
        return {
            clientes: [],
            cliente: null,
            contratos_ejecucion: [],
            contratos_terminados: [],
            contrato: {},
            loading: false,
            headers: [
                { text: "Descripción del Contrato", value: "descripción" },
                { text: "Fecha de Inicio", value: 'fecha_inicio' },
                { text: "Fecha Finalización", value: 'fecha_fin' },
                { text: "Servicio", value: 'area' },
                { text: "Avance" },
                { text: "Estado", value: 'estado', sortable: false }
            ],

            /*chartData: null, // Datos para el gráfico de pastel
            chartOptions: {
                title: 'Contratos en ejecución y terminados',
                pieHole: 0.4, // Agujero en el centro del pastel (0-1)
            },*/

        }
    },
    created() {

        this.fetchClientes();
        this.fetchContratos();
        //this.updateChartData();

    },

    methods: {
        fetchClientes() {
            this.axios.get("/api/clientes/").then((response) => {
                this.clientes = response.data;
            });
        },
        fetchContratos() {
            this.axios.get(`/api/contrato-activo-all`).then((response) => {
                this.contratos_ejecucion = response.data;
                //console.log(this.contratos_ejecucion)
            });

            this.axios.get(`/api/contrato-terminado-all`).then((response) => {
                this.contratos_terminados = response.data;
            });
        },
        verContratos() {
            console.log(this.cliente)

            if (this.cliente === null) {
                this.fetchContratos();
            } else {
                this.axios.get(`/api/contratoActivo-cliente/${this.cliente}`).then((response) => {
                    this.contratos_ejecucion = response.data;
                });
                this.axios.get(`/api/contratoTerminado-cliente/${this.cliente}`).then((response) => {
                    this.contratos_terminados = response.data;
                });
            }
        },
        calcularPorcentajeAvance(fechaInicio, fechaFin) {
            const fechaActual = new Date();
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);

            const totalMillis = fin - inicio;
            const elapsedMillis = fechaActual - inicio;

            const porcentaje = (elapsedMillis / totalMillis) * 100;
            return porcentaje > 100 ? 100 : porcentaje; // No más del 100%
        },
        calcularColorPorcentajeAvance(fechaInicio, fechaFin) {
            const porcentaje = this.calcularPorcentajeAvance(fechaInicio, fechaFin);

            if (porcentaje >= 0 && porcentaje < 80) {
                return "green"; // Verde
            } else if (porcentaje >= 80 && porcentaje < 95) {
                return "orange"; // Naranja
            } else if (porcentaje >= 95 && porcentaje < 99) {
                return "red"; // Rojo
            } else if (porcentaje === 100) {
                return "blue"; // Azul
            }
        },
        updateChartData() {
            const ejecucionCount = this.contratos_ejecucion.length;
            const terminadosCount = this.contratos_terminados.length;

            // Crea los datos en el formato requerido para el gráfico de pastel
            this.chartData = [
                ['Estado', 'Cantidad'],
                ['En ejecución', ejecucionCount],
                ['Terminados', terminadosCount],
            ];
        },
    }
}
</script>


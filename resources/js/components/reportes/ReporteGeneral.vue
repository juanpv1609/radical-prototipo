<template>
    <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6">Reporte de Contratos
            </v-card-title>

            <v-card-text>
                <v-form ref="form" v-model="valid">
                    <v-row>
                        <v-col cols="6" sm="6">
                            <v-btn block color="red" :loading="loadingUpload" dark @click="generarReportePDF">
                                Generar Reporte en PDF
                            </v-btn>
                        </v-col>
                        <v-col cols="6" sm="6">
                            <v-bton color="green" :loading="loadingUpload" dark @click="generarReporteCSV">
                                Generar Reporte en CSV
                            </v-bton>
                        </v-col>
                    </v-row>
                </v-form>


            </v-card-text>
        </v-card>
    </div>
</template>

<script>
export default {
    data() {
        return {

            loading: false,
            loadingUpload: false,
            dates: [],
            valid: true,
            dateRules: [
                v => !!v || 'Date range is required',
            ],
        };
    },
    computed: {
        dateRangeText() {
            return this.dates.join(' ~ ')
        },
    },
    created() {


    },
    methods: {
        async generarReportePDF() {
            this.loading = true;
            this.loadingUpload = true;
            let url;
            await this.axios
                .get(`/api/reporte-contratos-pdf/`)
                .then(response => {
                    url = response.config.baseURL + response.config.url;

                }).catch((error) => (console.log(error)));

            this.loading = false;
            this.loadingUpload = false;
            this.dates = [];
            this.valid = true;
            window.open(url, '_blank');

        },
        async generarReporteCSV() {
            this.loading = true;
            this.loadingUpload = true;
            let url;
            await this.axios
                .get(`/api/reporte-contratos-csv/`)
                .then(response => {
                    url = response.config.baseURL + response.config.url;

                }).catch((error) => (console.log(error)));

            this.loading = false;
            this.loadingUpload = false;
            this.dates = [];
            this.valid = true;
            window.open(url, '_blank');

        }
    }
}
</script>

<style></style>

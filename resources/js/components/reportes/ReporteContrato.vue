<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte de Tareas por Contrato
            </v-card-title>

            <v-card-text>
                <v-form ref="form"
                        v-model="valid"
                        lazy-validation>
                        <v-row>
                            <v-col
                            cols="12"

                            >
                            <v-select :items="contratos"
                                            v-model="contrato"
                                                label="Seleccione un Contrato"
                                                @change="setDates"
                                                >
                                            <template slot="selection" slot-scope="data">
                                                <!-- HTML that describe how select should render selected items -->
                                                ({{ data.item.cliente.nombre_comercial }}) {{ data.item.observacion }}
                                            </template>
                                            <template slot="item" slot-scope="data">
                                                <!-- HTML that describe how select should render items when the select is open -->
                                               ({{ data.item.cliente.nombre_comercial }}) {{ data.item.observacion }}
                                            </template>
                                        </v-select>
                            </v-col>
                        </v-row>
                        <v-row>
                    <v-col cols="12">
                        <v-row>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range
                                width="500"

                            ></v-date-picker>
                            </v-col>


                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-row>
                                <v-col cols="12" >
                                    <v-text-field
                                v-model="b"
                                label="Rango de fechas"
                                prepend-icon="mdi-calendar"

                                :rules="dateRules"
                            ></v-text-field>
                                </v-col>


                                <v-btn  block color="primary" :loading="loadingUpload" dark  @click="generarReporte">Generar Reporte</v-btn>
                            </v-row>


                            </v-col>
                        </v-row>
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
            contratos: [],
            contrato:null,
            loading: false,
            loadingUpload: false,
            dates: [],
            a:null,
            valid: true,
            dateRules: [
                 v => !!v || 'Date range is required',
             ],
        };
    },
    computed: {

      b: {
    // getter
            get: function () {
                this.a=this.dates.join(' ~ ')
                return this.a
            },
            // setter
            set: function (newValue) {
                this.a = newValue;


            }
        }
    },
    created() {
         this.axios.get("/api/contratos/").then(response => {
                                this.contratos = response.data;
                                console.log(response.data);
                            });


    },
    methods: {
        setDates(contrato){
            console.log(contrato);
             this.dates[0] = contrato.fecha_inicio;
             this.dates[1] = contrato.fecha_fin;
             //this.dateRangeText.set = this.dates;
             this.b = this.dates;
        },
        async generarReporte(){
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.loadingUpload=true;
                let url;
             await   this.axios
                    .get(`/api/reporte-tareas-contrato/${this.dates[0]}/${this.dates[1]}/${this.contrato.id}`)
                    .then(response => {
                        url=response.config.baseURL+response.config.url;

                    }).catch((error)=>(console.log(error)));

                    this.loading = false;
                    this.loadingUpload=false;
                    this.dates = [];
                    this.valid = true;
                    window.open(url,'_blank');
            }

        }
    }
}
</script>

<style>

</style>

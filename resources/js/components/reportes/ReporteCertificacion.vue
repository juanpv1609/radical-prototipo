<template>
  <div>
        <v-card elevation="2" :loading="loading">
            <v-card-title class="d-flex justify-space-between mb-6"
                >Reporte por certificaciones
            </v-card-title>

            <v-card-text>
                <v-form ref="form"
                        v-model="valid"
                        lazy-validation>
                        <v-row>
                    <v-col cols="12" md="8">
                        <v-autocomplete
                                deletable-chips
                                multiple
                                small-chips
                                clearable
                                :items="certificaciones"

                                item-text="solucion"
                                item-value="id"
                                v-model="selectedCertificacion"
                                label="Seleccione una o varias certificaciones"
                                dense
                                return-object

                            >
                            <template v-slot:prepend-item>
                                    <v-list-item
                                    ripple
                                    @click="toggle"
                                    >
                                    <v-list-item-action>
                                        <v-icon :color="selectedCertificacion.length > 0 ? 'indigo darken-4' : ''">
                                        {{ icon }}
                                        </v-icon>
                                    </v-list-item-action>
                                    <v-list-item-content>
                                        <v-list-item-title>
                                        Seleccionar Todo
                                        </v-list-item-title>
                                    </v-list-item-content>
                                    </v-list-item>
                                    <v-divider class="mt-2"></v-divider>
                                </template>
                            </v-autocomplete>


                        </v-col>
                        <v-col cols="12" md="4">
                            <v-btn  block color="primary" :loading="loadingUpload" :disabled="!selectedCertificacion.length>0" dark
                                @click="generarReporte">Generar Reporte</v-btn>
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
            certificaciones: [],
            selectedCertificacion:[],

            loading: false,
            loadingUpload: false,
            valid: true,
            certificacionRules: [
                 v => !!v || 'Certificación is required',
             ],
        };
    },
    created() {
        this.axios.get("/api/get-certificaciones/").then(response => {
                this.certificaciones = response.data;
                //console.log(response.data);
            });

    },computed: {
      likesAllCertifications () {
        return this.selectedCertificacion.length === this.certificaciones.length
      },
      likesSomeCertifications () {
        return this.selectedCertificacion.length > 0 && !this.likesAllCertifications
      },
      icon () {
        if (this.likesAllCertifications) return 'mdi-close-box'
        if (this.likesSomeCertifications) return 'mdi-minus-box'
        return 'mdi-checkbox-blank-outline'
      },
    },
    methods: {
        toggle () {
        this.$nextTick(() => {
          if (this.likesAllCertifications) {
            this.selectedCertificacion = []
          } else {
            this.selectedCertificacion = this.certificaciones.slice()
          }
        })
      },
        async generarReporte(){
            if (this.$refs.form.validate()) {
                this.loading = true;
                this.loadingUpload=true;
                let url;
                console.log(this.selectedCertificacion);
                var arrayCertificacionesID = [];
                for (let index = 0; index < this.selectedCertificacion.length; index++) {
                    arrayCertificacionesID[index]=this.selectedCertificacion[index].id;

                }
                console.log(arrayCertificacionesID);
              await   this.axios
                    .get(`/api/reporte-certificaciones/${arrayCertificacionesID}`)
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

<template>
    <div>
        <h3 class="d-flex justify-space-between mb-6 pt-4">
            Editar Registro
                <v-btn
                    class="mx-2"
                    dark
                    color="primary"
                    @click="createPerson"
                    :disabled="estudios.length==0"
                >
                  <v-icon>mdi-content-save</v-icon>  GUARDAR
                </v-btn>
        </h3>

                <v-form v-model="valid">
                <v-card elevation="2" outlined shaped :loading="loading" >
                    <v-subheader class="text-primary">
                        <strong>DATOS PERSONALES</strong>
                    </v-subheader>
                    <v-card-text>
                        <v-row>
                            <v-col cols="12" md="2" >
                                <v-row class="d-flex justify-space-center">
                                    <v-col cols="12">
                                        <v-card outlined   elevation="1">
                                        <v-card-text height="150"
                                        width="155">
                                            <v-img class="d-flex justify-space-center"
                                                max-height="150"
                                                max-width="150"
                                                v-if="url_persona_foto" :src="url_persona_foto"
                                                ></v-img>
                                                <v-icon v-else size="160" class="d-flex justify-space-center">mdi-account</v-icon>
                                        </v-card-text>


                                        </v-card>

                                    </v-col>
                                </v-row>
                            </v-col>
                            <v-col cols="12" md="10">
                                <v-row >
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="persona.nombre"
                                            :rules="Rules.nombre"
                                            label="Nombre*"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="persona.apellido"
                                            :rules="Rules.apellido"
                                            label="Apellido*"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="persona.ci"
                                            :counter="10"
                                            label="CI (Documento de identidad)*"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="persona.email"
                                            :rules="Rules.email"
                                            label="Email*"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                     <v-col cols="12" md="4">
                                        <v-autocomplete
                                            :items="paises"

                                            item-text="nombre"
                                            item-value="id"
                                            v-model="persona.pais_id"
                                            label="Pais de residencia"
                                            :rules="Rules.pais_id"
                                            dense
                                        ></v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-autocomplete
                                             :items="paises"

                                            item-text="nombre"
                                            item-value="id"
                                            v-model="persona.nacionalidad_id"
                                            label="Nacionalidad"
                                            :rules="Rules.nacionalidad_id"
                                            dense
                                        ></v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-file-input
                                            small-chips
                                            accept="image/*"
                                            v-model="persona.foto"
                                            label="Fotografia"
                                            @change="onFotoChange"
                                            prepend-icon="mdi-camera"
                                            dense
                                            >
                                        </v-file-input>
                                    </v-col>
                                    <v-col cols="12" md="4">
                                        <v-text-field
                                            v-model="persona.telefono"
                                            :counter="10"
                                            label="Telefono"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="4">

                                        <template>
                                            <v-menu
                                                ref="menu"
                                                v-model="menu"
                                                :close-on-content-click="false"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="auto"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="date"
                                                    label="Fecha de nacimiento"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    dense
                                                ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                ref="picker"
                                                v-model="date"
                                                :max="new Date().toISOString().substr(0, 10)"
                                                min="1950-01-01"
                                                @change="save"
                                                ></v-date-picker>
                                            </v-menu>
                                            </template>
                                    </v-col>
                                </v-row>

                            </v-col>

                        </v-row>
                        <v-row>
                            <v-col cols="12">
                                <template v-if="estudios.length>0">

                                        <v-subheader class="text-primary">
                                            <v-badge
                                            :content="estudios.length"
                                            :value="estudios.length"
                                            color="green"

                                        >
                                        <strong>ESTUDIOS</strong>
                                        </v-badge>
                                    </v-subheader>
                                <v-simple-table  dense  fixed-header height="200px">
                                    <template v-slot:default>
                                    <thead>
                                        <tr>
                                        <th class="text-left">
                                            Institucion
                                        </th>
                                        <th class="text-left">
                                            Descripcion
                                        </th>
                                        <th class="text-left">
                                            Inicio
                                        </th>
                                        <th class="text-left">
                                            Fin
                                        </th>
                                        <th class="text-left">
                                            Estado
                                        </th>
                                        <th class="text-left">
                                            Eliminar
                                        </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                        v-for="item in estudios"
                                        :key="item.id"
                                        >
                                        <td>{{ item.institucion }}</td>
                                        <td>{{ item.descripcion }}</td>
                                        <td>{{ item.fecha_inicio }}</td>
                                        <td>{{ item.fecha_fin }}</td>
                                        <td> <v-chip v-if="item.estado_estudio_id==1"

                                                color="success"
                                                small
                                                >Terminado
                                                </v-chip>
                                                <v-chip v-else-if="item.estado_estudio_id==2"

                                                color="primary"
                                                small
                                                >En curso
                                                </v-chip>
                                                <v-chip v-else

                                                color="error"
                                                small
                                                >Abandonado
                                                </v-chip>
                                        </td>
                                        <td>
                                            <v-btn small icon color="error" @click="deleteEducacion(item)">
                                                <v-icon dark>mdi-delete</v-icon>
                                            </v-btn>
                                        </td>
                                        </tr>
                                    </tbody>
                                    </template>
                                </v-simple-table>

                        </template>
                            </v-col>
                        </v-row>
                    </v-card-text>
                </v-card>
                <br>
                <v-card elevation="2" outlined shaped >
                    <v-subheader class="text-primary">
                                <strong>AÑADIR EDUCACION</strong>
                            </v-subheader>
                    <v-card-text>
                                <v-row >
                                    <v-col cols="12" md="12">
                                        <v-textarea
                                            clearable
                                            clear-icon="mdi-close-circle"
                                            label="Descripción / Título"
                                            v-model="estudio.descripcion"
                                            :rules="Rules.estudio_descripcion"
                                            rows="1"
                                            dense
                                            ></v-textarea>
                                    </v-col>
                                    <v-col cols="12" md="6">
                                        <v-text-field
                                            v-model="estudio.institucion"
                                            :rules="Rules.estudio_institucion"
                                            label="Institucion*"
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-autocomplete
                                            :items="paises"

                                            item-text="nombre"
                                            item-value="id"
                                            v-model="estudio.pais_id"
                                            label="Pais de emision"
                                            :rules="Rules.estudio_pais"
                                            dense
                                        ></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" md="2">
                                        <v-dialog
                                                ref="menu_fecha_inicio_estudio"
                                                v-model="menu_fecha_inicio_estudio"
                                                :close-on-content-click="true"
                                                :return-value.sync="date"
                                                persistent
                                                width="290px"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="estudio.fecha_inicio"
                                                    label="Fecha inicial"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    dense
                                                ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                v-model="estudio.fecha_inicio"
                                                type="month"
                                                no-title
                                                scrollable
                                                >
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="menu_fecha_inicio_estudio = false"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn

                                                    color="primary"
                                                    @click="$refs.menu_fecha_inicio_estudio.save(date)"
                                                >
                                                    OK
                                                </v-btn>
                                                </v-date-picker>
                                            </v-dialog>
                                    </v-col>

                                    <v-col cols="12" md="2">
                                        <v-dialog
                                                ref="menu_fecha_fin_estudio"
                                                v-model="menu_fecha_fin_estudio"
                                                :close-on-content-click="true"
                                                :return-value.sync="date"
                                                persistent
                                                width="290px"
                                            >
                                                <template v-slot:activator="{ on, attrs }">
                                                <v-text-field
                                                    v-model="estudio.fecha_fin"
                                                    label="Fecha final"
                                                    readonly
                                                    v-bind="attrs"
                                                    v-on="on"
                                                    dense
                                                ></v-text-field>
                                                </template>
                                                <v-date-picker
                                                v-model="estudio.fecha_fin"
                                                type="month"
                                                no-title
                                                scrollable
                                                >
                                                <v-spacer></v-spacer>
                                                <v-btn
                                                    text
                                                    color="primary"
                                                    @click="menu_fecha_fin_estudio = false"
                                                >
                                                    Cancel
                                                </v-btn>
                                                <v-btn

                                                    color="primary"
                                                    @click="$refs.menu_fecha_fin_estudio.save(date)"
                                                >
                                                    OK
                                                </v-btn>
                                                </v-date-picker>
                                            </v-dialog>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-text-field
                                            v-model="estudio.duracion_horas"
                                            label="Duracion (Horas) "
                                            required
                                            dense
                                        ></v-text-field>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-autocomplete
                                            :items="nivel_estudio"

                                            item-text="descripcion"
                                            item-value="id"
                                            v-model="estudio.nivel_id"
                                            label="Nivel / Tipo de estudio"
                                            :rules="Rules.estudio_nivel"
                                            dense
                                        ></v-autocomplete>
                                    </v-col>
                                    <v-col cols="12" md="2">
                                        <v-autocomplete
                                            :items="estado_estudio"

                                            item-text="descripcion"
                                            item-value="id"
                                            v-model="estudio.estado_estudio_id"
                                            label="Estado de estudio"
                                            :rules="Rules.estudio_estado"
                                            dense
                                        ></v-autocomplete>
                                    </v-col>

                                    <v-col cols="12" md="6">
                                        <v-file-input
                                            multiple
                                            chips
                                            show-size
                                            counter
                                            accept="image/*"
                                            v-model="estudio.documentos"
                                            label="Documentos (Ej: Certificados, Comprobantes, etc)"
                                            dense
                                        ></v-file-input>
                                    </v-col>
                                    <v-col cols="12" md="12" v-if="estudio.nivel_id==7">
                                        <v-autocomplete
                                            :items="certificaciones"

                                            item-text="solucion"
                                            item-value="id"
                                            v-model="estudio.certificado"
                                            label="Seleccione una certificación"
                                            dense

                                        >
                                        <template v-slot:append-outer>
                                            <v-slide-x-reverse-transition
                                                mode="out-in"
                                            >
                                            <v-btn color="orange" dense @click="add">NUEVA CERTIFICACION</v-btn>

                                            </v-slide-x-reverse-transition>
                                            </template>
                                        </v-autocomplete>

                                    </v-col>

                                    <v-col cols="12" >
                                            <v-btn
                                            block
                                            dark
                                            color="green"
                                            @click="addEducacion"

                                        ><v-icon dark>
                                                    mdi-plus
                                                </v-icon>
                                            AÑADIR EDUCACION
                                        </v-btn>
                                    </v-col>

                                </v-row>
                            </v-card-text>
                </v-card>
                <br>
                    </v-form>
                    <template>
                <v-row justify="center">
                    <v-dialog v-model="dialog" persistent max-width="600px">
                        <v-card>
                            <v-card-title>
                                <span class="headline">{{ titleForm }}</span>
                            </v-card-title>
                            <v-card-text>
                                <v-container>
                                    <v-row dense>
                                        <v-col cols="12">
                                            <v-textarea
                                            clearable
                                                v-model="certificacion.solucion"
                                                label="Nombre de la solución o herramienta*"
                                                required
                                                rows="3"
                                            ></v-textarea>
                                        </v-col>
                                    </v-row>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-switch
                                            v-model="certificacion.estado"
                                            :label="`${(certificacion.estado==true) ? 'HABILITADO' : 'DESHABILITADO'}`"
                                            ></v-switch>
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

                                    @click="createCertificate"
                                >
                                    Guardar
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
            certificacion: {},
            date: null,
            menu: false,
            menu_fecha_inicio_estudio:false,
            menu_fecha_fin_estudio:false,
            url_persona_foto:null,
            persona_foto:null,
            personas: [],
            paises: [],
            nivel_estudio: [],
            estado_estudio: [],
            dialog: false,
            update: false,
            persona: {},
            request: {},
            estudio: {},
            estudios: [],
            certificaciones: [],
            loading: true,
            titleForm: null,
            search: "",
            valid:true,
            roles: [
                {
                    value: 1,
                    text: "Consulta"
                },
                {
                    value: 2,
                    text: "Adminstrador"
                }
            ],
            headers: [
                {
                    text: "Id",
                    // align: 'start',
                    // filterable: false,
                    value: "id"
                },
                { text: "Nombre", value: "nombre" },
                { text: "Email", value: "email" },
                { text: "Rol", value: "role" },
                { text: "Fecha creacion", value: "created_at" },
                { text: "Acciones", value: "controls", sortable: false }
            ],
            Rules : {
                nombre: [
                    v => !!v || 'Este campo es requerido'
                ],
                apellido: [
                    v => !!v || 'Este campo es requerido'
                ],
                ci: [
                    v => !!v || 'Este campo es requerido',
                    v => v.length = 10 || 'Este campo debe tener como máximo 10 caracteres',
                ],
                email: [
                    v => !!v || 'Este campo es requerido',
                    v => /.+@.+/.test(v) || 'E-mail no valido',
                ],
                pais_id: [
                    v => !!v || 'Este campo es requerido'
                ],
                nacionalidad_id: [
                    v => !!v || 'Este campo es requerido'
                ],
                estudio_institucion: [
                    v => !!v || 'Este campo es requerido'
                ],
                estudio_descripcion: [
                    v => !!v || 'Este campo es requerido'
                ],
                estudio_pais: [
                    v => !!v || 'Este campo es requerido'
                ],
                estudio_nivel: [
                    v => !!v || 'Este campo es requerido'
                ],
                estudio_estado: [
                    v => !!v || 'Este campo es requerido'
                ],
            }
        };
    },
    watch: {
      menu (val) {
        val && setTimeout(() => (this.$refs.picker.activePicker = 'YEAR'))
      },
    },
    created() {

        this.initialData();
    },
    methods: {
        add() {

                this.titleForm = "Nueva Certificación";
                this.certificacion = {};
                this.update = false;
                this.dialog = true;
                this.certificacion.estado=true;
            },
        save (date) {
        this.$refs.menu.save(date)
      },
      onFotoChange() {
            if (this.persona.foto) {
                this.url_persona_foto = URL.createObjectURL(this.persona.foto);
                //this.crearFoto(this.persona.foto);
                this.crearFoto();

            }else{
                this.url_persona_foto = null;
                this.persona.fotoString = null;
            }
      },
      crearFoto(){
          var photo = '';
              const selectedFile = this.persona.foto;
              if (selectedFile) {
                const reader = new FileReader();
                var file;

                    reader.readAsDataURL(selectedFile)
                reader.onload = ()=> {
                    file = reader.result;
                    if (file) {
                            var persona_foto = file;
                            if (!(persona_foto === "" || persona_foto === null || persona_foto === undefined)) {
                                persona_foto = persona_foto.substring(persona_foto.indexOf(",") + 1);
                                 this.persona.fotoString = persona_foto;
                            }

                        }

                    };
              }else{
                  this.persona.fotoString = null;
              }



      },
      test(){
        console.log(this.persona);
        //   this.persona.foto = this.crearFoto();
      },

      crearDocumentos(documentos){
          var files = [];
          if (documentos) {
              for (const item of documentos) {
              const selectedFile = item;
                const reader = new FileReader();
                var file;
                reader.onload = ()=> {
                    file = reader.result;
                    if (file) {
                            var documento = file;
                            if (!(documento === "" || documento === null || documento === undefined)) {
                                documento = documento.substring(documento.indexOf(",") + 1);
                                files.push(documento);
                            }
                        }
                    };
                    reader.readAsDataURL(selectedFile)
            }
          }else{
              files =  null
          }
              return files;


      },

      addEducacion(){
          var auxArray = [];
          this.estudios.push({
                institucion: (this.estudio.institucion) ? this.estudio.institucion : null,
                pais_id: (this.estudio.pais_id) ? this.estudio.pais_id : null,
                duracion_horas:this.estudio.duracion_horas || null,
                fecha_inicio:(this.estudio.fecha_inicio) ? `${this.estudio.fecha_inicio}-01` : null,
                fecha_fin:(this.estudio.fecha_fin)  ? `${this.estudio.fecha_fin}-01` : null,
                nivel_id:this.estudio.nivel_id,
                certificado:this.estudio.certificado || null,
                estado_estudio_id:this.estudio.estado_estudio_id,
                descripcion:this.estudio.descripcion,
                titulo:this.estudio.descripcion,
                documentos:this.crearDocumentos(this.estudio.documentos)
          })
          console.log(this.estudios);
          this.estudio={}
      },
      deleteEducacion(el) {
                let i = this.estudios.map(data => data.id).indexOf(el.id);
                this.estudios.splice(i, 1);
            },
        createPerson() {
            this.loading = true;
            this.persona.estudios=this.estudios;
            this.persona.fecha_nacimiento=this.date;


            console.log(this.persona);
              this.axios
              .patch(`/api/persona/${this.$route.params.id}`, this.persona)
                .then(response => {
                    this.dialog = false;
                    this.loading = false;
                    this.$toasted.success("Información actualizada correctamente");
                    this.initialData()

                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        initialData(){
            this.axios.get(`/api/persona/${this.$route.params.id}`).then(response => {
            //this.estudios = response.data;
            this.persona.nombre  =  response.data[0].persona.nombre;
            this.persona.apellido= response.data[0].persona.apellido;
            this.persona.ci= response.data[0].persona.ci;
            this.persona.email= response.data[0].persona.email;
            this.persona.pais_id= response.data[0].persona.pais_id;
            this.persona.nacionalidad_id= response.data[0].persona.nacionalidad_id;
            this.persona.telefono= response.data[0].persona.telefono;
            this.date= response.data[0].persona.fecha_nacimiento;
            this.save(this.date);
            //this.persona.foto= response.data[0].persona.foto;
            this.persona.fotoString = response.data[0].persona.foto;
            //this.crearFoto();
            this.url_persona_foto= 'data:image/png;base64,'+response.data[0].persona.foto;
            var arrayEstudios=[];
            response.data.forEach(element => {
                    arrayEstudios.push({
                        id: element.id,
                        institucion: element.institucion,
                        pais_id: element.pais_id,
                        duracion_horas: element.duracion_horas || null,
                        fecha_inicio: element.fecha_inicio,
                        fecha_fin: element.fecha_fin,
                        nivel_id: element.nivel_id,
                        certificado: element.certificado || null,
                        estado_estudio_id: element.estado_estudio_id,
                        descripcion: element.descripcion,
                        titulo: element.descripcion,
                        documentos:(element.documentos) ? element.documentos.split(",") : null
                })
            });
          this.estudios = arrayEstudios;
            console.log(this.estudios);
            this.loading = false;
        });
        this.axios.get("/api/paises/").then(response => {
                this.paises = response.data;
                //console.log(response.data);
            });
             this.axios.get("/api/get-nivel-estudio/").then(response => {
                this.nivel_estudio = response.data;
                //console.log(response.data);
            });
            this.axios.get("/api/estado-estudio/").then(response => {
                this.estado_estudio = response.data;
                //console.log(response.data);
            });
            this.axios.get("/api/get-certificaciones/").then(response => {
                this.certificaciones = response.data;
                //console.log(response.data);
            });
        },
        createCertificate() {
                this.certificacion.estado = (this.certificacion.estado) ? 1 : 0;
                 this.loading = true;
                this.axios
                    .post('/api/certificaciones', this.certificacion)
                    .then(response => {
                        this.dialog = false;
                        this.loading = false;
                        var auxCertificacion = response.data
                        this.axios
                            .get('/api/certificaciones')
                            .then(response => {
                                this.certificaciones = response.data;
                                this.estudio.certificado = auxCertificacion.id

                            });
                         })
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            },
    }
};
</script>

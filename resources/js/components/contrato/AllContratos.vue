<template>
    <div>
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Contratos</h5>
                <router-link
                    to="/contratos/create"
                    class="btn btn-primary btn-sm"
                    >Nuevo</router-link
                >
                <!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Nuevo
                    </button> -->
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table " v-if="contratos.length>0">
                        <thead class="table-dark">
                            <tr>
                                <th>Descripcion</th>
                                <th>Cliente</th>
                                <th>Fecha inicial</th>
                                <th>Fecha final</th>
                                <th>Area</th>
                                <th>Solucion</th>
                                <th>Marca</th>
                                <th>Tareas</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="item in contratos" :key="item.id">
                                <td>{{ item.descripcion }}</td>
                                <td>{{ item.cliente.nombre_comercial }}</td>
                                <td>{{ item.fecha_inicio }}</td>
                                <td>{{ item.fecha_fin }}</td>
                                <td>{{ item.area.nombre }}</td>
                                <td>{{ item.solucion }}</td>
                                <td>{{ item.marca }}</td>

                                <td>
                                    <!-- <div
                                    v-for="mant in item.mantenimiento"
                                    :key="mant.id"
                                >
                                    <span class="badge badge-success">{{
                                        mant.fecha
                                    }}</span>
                                </div> -->
                                    <div class="btn-group" role="group">
                                        <router-link
                                            :to="{
                                                name: 'contratos-tasks',
                                                params: { id: item.id }
                                            }"
                                            class="btn btn-warning btn-sm"
                                        >
                                            <i class="fas fa-plus-circle"></i>
                                        </router-link>
                                        <button
                                            class="btn btn-sm btn-primary"
                                            v-on:click="findTareas(item.id)"
                                        >
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <router-link
                                            :to="{
                                                name: 'contratos-edit',
                                                params: { id: item.id }
                                            }"
                                            class="btn btn-secondary btn-sm"
                                        >
                                            <i class="fas fa-edit"></i>
                                        </router-link>
                                        <button type="button" @click="sendMails(item.id)" class="btn btn-sm btn-primary">
                                            <i class="fas fa-envelope"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <p v-else class="alert alert-info">No se encontraron resultados :(</p>

                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="exampleModal2"
            tabindex="-1"
            role="dialog"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
        >
            <div
                class="modal-dialog modal-lg modal-dialog-scrollable"
                role="document"
            >
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">
                            Tareas Registradas
                        </h5>
                        <button
                            type="button"
                            class="close"
                            data-dismiss="modal"
                            aria-label="Close"
                        >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div
                            class="table-responsive overflow-auto "
                            v-bind:style="{ heigth: '50%' }"
                            v-if="tareas.length > 0"
                        >
                            <table class="table table-sm table-bordered" >
                                <thead class="table-dark">
                                    <tr>
                                        <th>Responsable</th>
                                        <th>Tipo</th>
                                        <th style="width:20%">Fecha</th>
                                        <th style="width:10%">Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr
                                        v-for="value in tareas"
                                        v-bind:key="value.id"
                                    >
                                        <td>
                                            <select
                                                v-model="value.responsable"
                                                class="form-control form-control-sm"
                                            >
                                                <option
                                                    v-for="item in responsables"
                                                    v-bind:key="item.value"
                                                    v-bind:value="item.value"
                                                >
                                                    {{ item.nombre }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <select
                                                v-model="value.tipo_tarea"
                                                class="form-control form-control-sm"
                                            >
                                                <option
                                                    v-for="item in tipo_tareas"
                                                    v-bind:key="item.value"
                                                    v-bind:value="item.value"
                                                >
                                                    {{ item.text }}
                                                </option>
                                            </select>
                                        </td>
                                        <td>
                                            <input
                                                type="date"
                                                class="form-control form-control-sm"
                                                v-model="value.fecha"
                                            />
                                        </td>
                                        <td>
                                            <span
                                                v-if="
                                                    value.estado_tarea.id == 1
                                                "
                                                class="badge badge-warning"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else-if="
                                                    value.estado_tarea.id == 2
                                                "
                                                class="badge badge-success"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else-if="
                                                    value.estado_tarea.id == 3
                                                "
                                                class="badge badge-danger"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                            <span
                                                v-else
                                                class="badge badge-info"
                                            >
                                                {{
                                                    value.estado_tarea
                                                        .descripcion
                                                }}</span
                                            >
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                            <p v-else class="alert alert-info">No se encontraron resultados :(</p>
                    </div>
                    <div class="modal-footer">
                        <div class="d-flex justify-content-between">
                            <button
                                type="button"
                                class="btn btn-secondary mr-4"
                                data-dismiss="modal"
                            >
                                Cerrar
                            </button>
                            <button
                                type="button"
                                class="btn btn-primary"
                                @click="updateTareas"
                                v-if="tareas.length>0"
                            >
                                Actualizar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import $ from "jquery";
export default {
    data() {
        return {
            contratos: [],
            correos:'',

            mantenimientos: {},
            tareas: {},
            request: {},
            modalShow: false,
            tipo_tareas: [
                { text: "Informe", value: 1 },
                { text: "Firewall", value: 2 },
                { text: "IPS", value: 3 }
            ],
            responsables: [
                { nombre: "Juan", value: 1 },
                { nombre: "Pedro", value: 2 },
                { nombre: "Jose", value: 3 }
            ]
        };
    },
    created() {
        this.axios.get("/api/contratos/").then(response => {
            this.contratos = response.data;
            //console.log(response.data);
        });
        //this.$swal('Hello Vue world!!!');
    },
    methods: {
        findTareas(id) {
            $("#exampleModal2").modal("show");
            console.log(id);
            this.axios.get(`/api/contrato-tareas/${id}`).then(res => {
                //this.contratos = res.data;
                console.log(res.data);
                this.tareas = res.data;
            });
        },
        updateTareas() {
            console.log(this.tareas);
            this.request.tareas = this.tareas;

            this.axios
                .post(`/api/tareasAll/`, this.request)
                .then(() => {
                    this.$toasted.success("Tareas actualizadas correctamente");

                    $("#exampleModal2").modal("hide");
                })
                .catch(err => console.log(err))
                .finally(() => (this.loading = false));
        },
        deleteClient(id) {
            this.axios.delete(`/api/contratos/${id}`).then(response => {
                let i = this.contratos.map(data => data.id).indexOf(id);
                this.contratos.splice(i, 1);
            });
        },
        async sendMails(id){
            //this.correos='';
           await this.axios
            .get(`/api/contratos/${id}`)
            .then((res) => {
                console.log(res.data);
                this.correos = res.data.correos.replace(',','<br>')
            });
            await this.$swal.fire({
                title: 'Esta seguro?',
                html: `Se enviara un correo a las siguientes direcciones:\n${this.correos}`,
                icon: 'question',
                showConfirmButton: true,
                showCancelButton: true

                }).then(res => {
                if (res.value) {
                    this.$swal.fire({
                        title: 'Espere',
                        text: 'Enviando correos...',
                        icon: 'info',
                        allowOutsideClick: false
                    });
                        this.$swal.showLoading();
                        this.axios.get(`/api/send-mails-client/${id}`).then(()=>{
                            this.$swal.fire({
                                title: 'Correcto',
                                text: 'Correos enviados correctamente!',
                                icon: 'success'
                                })


                        }).catch(()=>(console.log('error'))).finally(()=>{

                        });
                    }
                })

        }
    }
};
</script>

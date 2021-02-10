<template>
    <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h5 class="card-title">Usuarios</h5>
                    <router-link to="/usuarios/create" class="btn btn-primary btn-sm">Nuevo</router-link>

                </div>

                <div class="card-body">
                    <table class="table ">
                        <thead class="table-dark">
                            <tr>
                                <th>Id</th>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha creacion</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                                <tr v-for="usuario in usuarios" :key="usuario.id">
                                    <td>{{ usuario.id}}</td>
                                    <td>{{ usuario.name}}</td>
                                    <td>{{ usuario.email}}</td>
                                    <td>{{ (usuario.role==2) ? 'Administrador' : 'Consulta'}}</td>
                                    <td>{{ usuario.created_at}}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <router-link :to="{name: 'usuarios-edit', params: { id: usuario.id }}" class="btn btn-success btm-sm">
                                                <i class="fas fa-edit"></i>
                                            </router-link>
                                            <button :disabled="usuario.role==2" class="btn btn-danger btm-sm" @click="deleteUser(usuario.id)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                        </tbody>
                    </table>
                </div>
            </div>
</template>

<script>
import moment from 'moment';
    export default {
        data() {
            return {
                usuarios: [],

            }
        },
        created() {
            this.axios
                .get('/api/usuarios-all')
                .then(response => {
                    this.usuarios = response.data;
                    for (const item of this.usuarios) {
                        item.created_at=moment(item.created_at).format('DD/MM/YYYY hh:mm')
                    }
                    console.log(response.data);
                });
        },
        methods: {
            deleteUser(id) {
                this.axios
                    .delete(`/api/usuarios/${id}`)
                    .then(response => {
                        let i = this.usuarios.map(data => data.id).indexOf(id);
                        this.usuarios.splice(i, 1)
                    });
            }
        }
    }
</script>

<template>
    <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Editar usuario</h5>
            </div>
       <div class="card-body">
                <form @submit.prevent="updateUsuario">
                        <div class="row">

                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="nomnbre" class="form-label">Nombre y Apellido:</label>
                                <input type="text" class="form-control" v-model="user.name" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Direccion de correo:</label>
                                <input type="email" class="form-control"  v-model="user.email" required>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="mb-3">
                                <label for="dni" class="form-label">Rol:</label>
                                <select class="form-control" v-model="user.role">
                                    <option v-for="item in roles" :key="item.value" :value="item.value"> {{item.text}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
</template>

<script>
    export default {
        data() {
            return {
                user: {},
                tipo_identificacion: {},
                roles:[
                    {
                        value:1,
                        text: 'Consulta'
                    },
                    {
                        value:2,
                        text: 'Adminstrador'
                    }
                ]

            }
        },
        created() {
            this.axios
                .get(`/api/usuarios/${this.$route.params.id}`)
                .then((res) => {
                    this.user = res.data;
                    console.log(res.data);
                });
        },
        methods: {
            updateUsuario() {
                this.axios
                    .patch(`/api/usuarios/${this.$route.params.id}`, this.user)
                    .then((res) => {
                        this.$router.push({ name: 'usuarios' });
                    });
            }
        }
    }
</script>

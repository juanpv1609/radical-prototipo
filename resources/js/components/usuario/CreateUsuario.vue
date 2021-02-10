<template >
    <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h5 class="card-title">Nuevo usuario</h5>
            </div>
            <div class="card-body">
                <form  @submit.prevent="addUser" >
                    <div class="row">

                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="nomnbre" class="form-label">Nombre y Apellido:</label>
                                <input type="text" class="form-control" v-model="user.name" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Direccion de correo:</label>
                                <input type="email" class="form-control"  v-model="user.email" required>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="dni" class="form-label">Rol:</label>
                                <select class="form-control" v-model="user.role">
                                    <option v-for="item in roles" :key="item.value" :value="item.value"> {{item.text}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="mb-3">
                                <label for="razon_social" class="form-label">Password:</label>
                                <input type="password" class="form-control"  v-model="user.password" required disabled aria-describedby="emailHelp">
                                <div id="emailHelp" class="small form-text">Contraseña: R@dical2021</div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
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
            this.user.password='R@dical2021';
        },
        methods: {
            addUser() {
                console.log(this.user);
                this.axios
                    .post('/api/usuarios', this.user)
                    .then(response => (
                        this.$router.push({ name: 'usuarios' })
                    ))
                    .catch(err => console.log(err))
                    .finally(() => this.loading = false)
            }
        }
    }
</script>


import Register from "../components/auth/Register.vue";
import Login from "../components/auth/Login.vue";
import AllClientes from "../components/cliente/AllClientes.vue";

import AllContratos from "../components/contrato/AllContratos.vue";
import AddTaskContrato from "../components/contrato/AddTaskContrato.vue";

import AllAreas from "../components/area/AllAreas.vue";

import AllUsuarios from "../components/usuario/AllUsuarios.vue";

import AllTareas from "../components/tareas/AllTareas.vue";
import EditTarea from "../components/tareas/EditTarea.vue";

export const routes = [
    { path: "*", redirect: "/" },
    {
        name: "home",
        path: "/",
        component: Login
    },
    {
        path: "/register",
        name: "register",
        component: Register
    },
    {
        path: "/login",
        name: "login",
        component: Login
    },
    {
        name: "clientes",
        path: "/clientes",
        component: AllClientes
    },
    // contratos
    {
        name: "contratos",
        path: "/contratos",
        component: AllContratos
    },
    {
        name: "contratos-tasks",
        path: "/contratos/tasks/:id",
        component: AddTaskContrato
    },
    // areas
    {
        name: "areas",
        path: "/areas",
        component: AllAreas
        // beforeEnter: (to, from, next) => {
        //     if (!store.state.isUserLoggedIn) next({ name: 'login' })
        //     else next()
        //   }
    },
    // tareas
    {
        name: "tareas",
        path: "/tareas",
        component: AllTareas
    },
    {
        name: "tareas-edit",
        path: "/tareas/edit/:id",
        component: EditTarea
    },
    {
        name: "usuarios",
        path: "/usuarios",
        component: AllUsuarios
    },
];

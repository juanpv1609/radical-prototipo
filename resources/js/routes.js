
import Home from './components/Home.vue';
import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import AllClientes from './components/cliente/AllClientes.vue';
import CreateClient from './components/cliente/CreateClient.vue';
import EditClient from './components/cliente/EditClient.vue';

import AllContratos from './components/contrato/AllContratos.vue';
import CreateContrato from './components/contrato/CreateContrato.vue';
import EditContrato from './components/contrato/EditContrato.vue';
import AddTaskContrato from './components/contrato/AddTaskContrato.vue';

import AllAreas from './components/area/AllAreas.vue';
import CreateArea from './components/area/CreateArea.vue';
import EditArea from './components/area/EditArea.vue';

import AllUsuarios from './components/usuario/AllUsuarios.vue';
import CreateUsuario from './components/usuario/CreateUsuario.vue';
import EditUsuario from './components/usuario/EditUsuario.vue';

import AllTareas from './components/tareas/AllTareas.vue';
import EditTarea from './components/tareas/EditTarea.vue';
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllClientes
    },
    {
        path: '/register',
        name: 'register',
        component: Register,
        meta: {
            auth: false
        }
    },
    {
        path: '/login',
        name: 'login',
        component: Login
    },
    {
        name: 'clientes',
        path: '/clientes',
        component: AllClientes,
        meta: {
            auth: true
        }
    },
    {
        name: 'clientes-new',
        path: '/clientes/create',
        component: CreateClient,
        meta: {
            auth: true
        }
    },
    {
        name: 'clientes-edit',
        path: '/clientes/edit/:id',
        component: EditClient,
        meta: {
            auth: true
        }
    },
    // contratos
    {
        name: 'contratos',
        path: '/contratos',
        component: AllContratos,
        meta: {
            auth: true
        }
    },
    {
        name: 'contratos-new',
        path: '/contratos/create',
        component: CreateContrato,
        meta: {
            auth: true
        }
    },
    {
        name: 'contratos-edit',
        path: '/contratos/edit/:id',
        component: EditContrato,
        meta: {
            auth: true
        }
    },
    {
        name: 'contratos-tasks',
        path: '/contratos/tasks/:id',
        component: AddTaskContrato,
        meta: {
            auth: true
        }
    },
    // areas
    {
        name: 'areas',
        path: '/areas',
        component: AllAreas,
        meta: {
            auth: true
        }
    },
    {
        name: 'areas-new',
        path: '/areas/create',
        component: CreateArea,
        meta: {
            auth: true
        }
    },
    {
        name: 'areas-edit',
        path: '/areas/edit/:id',
        component: EditArea,
        meta: {
            auth: true
        }
    },
    // tareas
    {
        name: 'tareas',
        path: '/tareas',
        component: AllTareas,
        meta: {
            auth: true
        }
    },
    {
        name: 'tareas-edit',
        path: '/tareas/edit/:id',
        component: EditTarea,
        meta: {
            auth: true
        }
    },
    {
        name: 'usuarios',
        path: '/usuarios',
        component: AllUsuarios,
        meta: {
            auth: true
        }
    },
    {
        name: 'usuarios-new',
        path: '/usuarios/create',
        component: CreateUsuario,
        meta: {
            auth: true
        }
    },
    {
        name: 'usuarios-edit',
        path: '/usuarios/edit/:id',
        component: EditUsuario,
        meta: {
            auth: true
        }
    },
];

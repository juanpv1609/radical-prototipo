// import AllProduct from './components/AllProduct.vue';
// import CreateProduct from './components/CreateProduct.vue';
// import EditProduct from './components/EditProduct.vue';
import AllClientes from './components/cliente/AllClientes.vue';
import CreateClient from './components/cliente/CreateClient.vue';
import EditClient from './components/cliente/EditClient.vue';

import AllContratos from './components/contrato/AllContratos.vue';
import CreateContrato from './components/contrato/CreateContrato.vue';
import EditContrato from './components/contrato/EditContrato.vue';

import AllAreas from './components/area/AllAreas.vue';
import CreateArea from './components/area/CreateArea.vue';
import EditArea from './components/area/EditArea.vue';
export const routes = [
    {
        name: 'home',
        path: '/',
        component: AllClientes
    },
    /* {
        name: 'create',
        path: '/create',
        component: CreateProduct
    },
    {
        name: 'edit',
        path: '/edit/:id',
        component: EditProduct
    }, */
    {
        name: 'clientes',
        path: '/clientes',
        component: AllClientes
    },
    {
        name: 'clientes-new',
        path: '/clientes/create',
        component: CreateClient
    },
    {
        name: 'clientes-edit',
        path: '/clientes/edit/:id',
        component: EditClient
    },
    // contratos
    {
        name: 'contratos',
        path: '/contratos',
        component: AllContratos
    },
    {
        name: 'contratos-new',
        path: '/contratos/create',
        component: CreateContrato
    },
    {
        name: 'contratos-edit',
        path: '/contratos/edit/:id',
        component: EditContrato
    },
    // areas
    {
        name: 'areas',
        path: '/areas',
        component: AllAreas
    },
    {
        name: 'areas-new',
        path: '/areas/create',
        component: CreateArea
    },
    {
        name: 'areas-edit',
        path: '/areas/edit/:id',
        component: EditArea
    }
];

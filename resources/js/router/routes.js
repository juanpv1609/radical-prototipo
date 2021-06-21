import VueRouter from 'vue-router';
import store from '../store/store';
import Register from "../components/auth/Register.vue";
import Login from "../components/auth/Login.vue";
import AllClientes from "../components/cliente/AllClientes.vue";

import AllContratos from "../components/contrato/AllContratos.vue";
import AddTaskContrato from "../components/contrato/AddTaskContrato.vue";

import AllAreas from "../components/area/AllAreas.vue";

import AllUsuarios from "../components/usuario/AllUsuarios.vue";

import AllTareas from "../components/tareas/AllTareas.vue";
import CalendarTareas from "../components/tareas/CalendarTareas.vue";
import EditTarea from "../components/tareas/EditTarea.vue";

import TipoTareas from "../components/tipo_tareas/TipoTareas.vue";

import ReporteTarea from "../components/reportes/ReporteTarea.vue";
import ReporteContrato from "../components/reportes/ReporteContrato.vue";
import ReporteUsuario from "../components/reportes/ReporteUsuario.vue";
import ReporteAllContratos from "../components/reportes/ReporteAllContratos.vue";
import Home from "../components/Home.vue";
import Frecuencia from "../components/frecuencia/Frecuencia.vue";
import Pais from "../components/pais/Pais.vue";
import CasosDeUso from "../components/casos/AllCasosDeUso.vue";

const router = new VueRouter({
    mode: "history",
    routes: [
        { path: "*", redirect: "/" },
        {
            name: "home",
            path: "/",
            component: Home,
            meta: {
                requiresAuth: true
            }
        },
        {
            path: "/register",
            name: "register",
            component: Register,
            meta: {
                requiresAuth: false
            }
        },
        {
            path: "/login",
            name: "login",
            component: Login,
            meta: {
                requiresAuth: false
            }
        },
        {
            name: "clientes",
            path: "/clientes",
            component: AllClientes,
            meta: {
                requiresAuth: true
            }
        },
        // contratos
        {
            name: "contratos",
            path: "/contratos",
            component: AllContratos,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "contratos-tasks",
            path: "/contratos/tasks/:id",
            component: AddTaskContrato,
            meta: {
                requiresAuth: true
            }
        },
        // areas
        {
            name: "areas",
            path: "/areas",
            component: AllAreas,
            meta: {
                requiresAuth: true
            }
        },
        // tareas
        {
            name: "tareas",
            path: "/tareas",
            component: AllTareas,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "calendar-tareas",
            path: "/calendar-tareas",
            component: CalendarTareas,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "tareas-edit",
            path: "/tareas/edit/:id",
            component: EditTarea,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "usuarios",
            path: "/usuarios",
            component: AllUsuarios,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "tipo-tareas",
            path: "/tipo-tareas",
            component: TipoTareas,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "reporte-tareas",
            path: "/reporte-tareas",
            component: ReporteTarea,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "reporte-contratos",
            path: "/reporte-contratos",
            component: ReporteContrato,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "reporte-usuario",
            path: "/reporte-usuario",
            component: ReporteUsuario,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "reporte-allContratos",
            path: "/reporte-allContratos",
            component: ReporteAllContratos,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "frecuencias",
            path: "/frecuencias",
            component: Frecuencia,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "paises",
            path: "/paises",
            component: Pais,
            meta: {
                requiresAuth: true
            }
        },
        {
            name: "casos-de-uso",
            path: "/casos-de-uso",
            component: CasosDeUso,
            meta: {
                requiresAuth: true
            }
        }
    ]
});

router.beforeEach( (to, from, next) => {
    if (  to.matched.some(record => record.meta.requiresAuth)) {

            if ( store.state.auth) {
                return next()
            } else
            next('/login')
        } else {
            next()
        }
    })

export default router

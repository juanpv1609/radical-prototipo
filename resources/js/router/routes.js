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
import AllTareasGeneral from "../components/tareas/AllTareasGeneral.vue";
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
//----------PERSONAL-----------
import Personal from "../components/personal/Personal.vue";
import PersonalNew from "../components/personal/PersonalNew.vue";
import PersonalEdit from "../components/personal/PersonalEdit.vue";
import Certificaciones from "../components/certificaciones/Certificaciones.vue";
import NivelEstudio from "../components/nivelEstudio/NivelEstudio.vue";
import ReporteCertificacion from "../components/reportes/ReporteCertificacion.vue";
import ReporteGeneral from "../components/reportes/ReporteGeneral.vue";
import ReportePersona from "../components/reportes/ReportePersona.vue";

//nuevas funciones ISO
import PerfilPuesto from "../components/perfilPuesto/PerfilPuesto.vue";
import Servicios from "../components/servicios/Servicios.vue";
import Marcas from "../components/marca/Marcas.vue";

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
            name: "all-tareas",
            path: "/all-tareas",
            component: AllTareasGeneral,
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
        },
        //  PERSONAL

        {
            name: "personal",
            path: "/personal",
            component: Personal,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "personal-new",
            path: "/personal-new",
            component: PersonalNew,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "personal-edit",
            path: "/personal/edit/:id",
            component: PersonalEdit,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "certificaciones",
            path: "/certificaciones",
            component: Certificaciones,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "nivel-estudio",
            path: "/nivel-estudio",
            component: NivelEstudio,
            meta: {
                requiresAuth: true,
            },
        },
        //REPORTES
        {
            name: "reporte-certificacion",
            path: "/reporte-certificacion",
            component: ReporteCertificacion,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "reporte-persona",
            path: "/reporte-persona",
            component: ReportePersona,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "reporte-general",
            path: "/reporte-general",
            component: ReporteGeneral,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "perfil-puesto",
            path: "/perfil-puesto",
            component: PerfilPuesto,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "servicios",
            path: "/servicios",
            component: Servicios,
            meta: {
                requiresAuth: true,
            },
        },
        {
            name: "marcas",
            path: "/marcas",
            component: Marcas,
            meta: {
                requiresAuth: true,
            },
        },
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

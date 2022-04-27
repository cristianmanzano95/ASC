const routes = [
  {
    path: "",
    component: () => import("src/layouts/utp-layout/utp-layout.vue"),
    children: [
      {
        path: "/formulario",
        component: () => import("src/pages/usuario/formulario.vue"),
        meta: {
          title:
            "Recursos Informáticos y Educativos CRIE :: Solicitud Sala de Cómputo Para Docentes",
          requireUser: true
        }
      },
      {
        path: "/login",
        name: "login",
        component: () => import("src/pages/usuario/login.vue"),
        meta: { title: "Iniciar sesión", requireNoUser: true }
      }
    ]
  },
  {
    path: "/solicitudes",
    component: () => import("src/layouts/admin-layout.vue"),
    children: [
      {
        path: "pendientes",
        name: "pendientes",
        component: () => import("src/pages/administrador/solicitudes.vue")
      },
      {
        path: "confirmadas",
        name: "confirmadas",
        component: () => import("src/pages/administrador/solicitudes.vue")
      },
      {
        path: "asignadas",
        name: "asignadas",
        component: () => import("src/pages/administrador/solicitudes.vue")
      },
      {
        path: "rechazadas",
        name: "rechazadas",
        component: () => import("src/pages/administrador/solicitudes.vue")
      },
      {
        path: "/solicitudes",
        redirect: "solicitudes/pendientes"
      }
    ],
    meta: {
      requireAdmin: true
    }
  },
  {
    path: "/login-admin",
    name: "login-admin",
    component: () => import("src/pages/usuario/login.vue"),
    meta: {
      requireNoAdmin: true
    }
  },
  {
    path: "/token/:token",
    name: "token",
    component: () => import("src/pages/administrador/integracion-login.vue")
  },

  // Always leave this as last one,
  // but you can also remove it
  {
    path: "*",
    redirect: "/login"
    // component: () => import("pages/Error404.vue")
  }
];

export default routes;

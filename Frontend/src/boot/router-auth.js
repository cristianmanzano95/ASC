export default ({ router }) => {
  router.beforeEach((to, from, next) => {
    let admin = localStorage.getItem("token");
    let user = sessionStorage.getItem("token");
    if (to.matched.some(record => record.meta.requireUser) && !user) {
      next("/login");
    } else if (to.matched.some(record => record.meta.requireAdmin) && !admin) {
      next("/login-admin");
    } else if (to.matched.some(record => record.meta.requireNoAdmin) && admin) {
      next("/solicitudes/pendientes");
    } else if (to.matched.some(record => record.meta.requireNoUser) && user) {
      next("/formulario");
    } else {
      next();
    }
  });
};

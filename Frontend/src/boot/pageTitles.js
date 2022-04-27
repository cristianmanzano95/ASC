const DEFAULT_TITLE = "Administrador CRIE";
import Vue from "vue";
export default ({ router }) => {
  router.beforeEach((to, from, next) => {
    Vue.nextTick(() => {
      document.title = (to.meta && to.meta.title) || DEFAULT_TITLE;
    });
    next();
  });
};

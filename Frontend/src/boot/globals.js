import { date } from "quasar";

const dateFormat = valor => {
  let newDate = new Date(valor);
  return date.formatDate(newDate, "YYYY-MM-DD");
};
const dateFormatHour = valor => {
  let newDate = new Date(valor);
  return date.formatDate(newDate, "YYYY-MM-DD h:mm a");
};
export default ({ Vue }) => {
  const events = new Vue({});
  Vue.prototype.$diasDic = {
    1: "Lunes",
    2: "Martes",
    3: "Miércoles",
    4: "Jueves",
    5: "Viernes",
    6: "Sábado"
  };
  Vue.prototype.$tipo_salasDic = {
    0: "Sala de cómputo",
    1: "Sala de videoconferencia",
    2: "Cubículo de música"
  };
  Vue.prototype.$tipo_salas = [
    { value: "0", label: "Sala de cómputo" },
    { value: "1", label: "Sala de videoconferencia" },
    { value: "2", label: "Cubículo de música" }
  ];
  Vue.prototype.$dias = [
    { value: "1", label: "Lunes" },
    { value: "2", label: "Martes" },
    { value: "3", label: "Miércoles" },
    { value: "4", label: "Jueves" },
    { value: "5", label: "Viernes" },
    { value: "6", label: "Sábado" }
  ];
  Vue.prototype.$dateFormat = dateFormat;
  Vue.prototype.$dateFormatHour = dateFormatHour;
  Vue.prototype.$events = events;
};

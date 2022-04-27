import axios from "axios";
import { Notify } from "quasar";

let baseURLUser = "http://127.0.0.1:8000/api";
let baseURLAdmin = "http://127.0.0.1:8000/api/adm";
let http, httpAdmin;
let alertShowed = false;

export default ({ store, Vue, router }) => {
  http = axios.create({
    baseURL: baseURLUser,
    headers: {
      Accept: "application/json"
      // Authorization: "Bearer aC5wdWxnYXJpbjoxMDg4MDMyNjk0YQ=="
    }
  });
  httpAdmin = axios.create({
    baseURL: baseURLAdmin,
    headers: {
      Accept: "application/json"
      // Authorization: "Bearer aC5wdWxnYXJpbjoxMDg4MDMyNjk0YQ=="
    }
  });

  Vue.prototype.$http = http;
  Vue.prototype.$httpAdmin = httpAdmin;

  Vue.prototype.$http.interceptors.request.use(config => {
    config.headers["Authorization"] = sessionStorage.getItem("token");
    alertShowed = false;
    return config;
  });
  Vue.prototype.$http.interceptors.response.use(
    response => response,
    error => {
      console.log(error.response);
      if (
        error &&
        error.response &&
        error.response.status &&
        error.response.status === 401 &&
        error.response.statusText === "Unauthorized"
      ) {
        sessionStorage.clear();
        if (!alertShowed) {
          alertShowed = true;
          Notify.create({
            type: "warning",
            message: "Sesión expirada"
          });
          router.push("/login");
        }
        return Promise.resolve(); // Avoid showing any errors
      } else if (
        error &&
        error.response &&
        error.response.data &&
        error.response.data.detailed
      ) {
        Notify.create({
          type: "error",
          message: detailed
        });
      } else {
        Notify.create({
          type: "error",
          message: "Error de servidor"
        });
      }
    }
  );
  Vue.prototype.$httpAdmin.interceptors.request.use(config => {
    alertShowed = false;
    config.headers["Authorization"] = localStorage.getItem("token");
    return config;
  });
  Vue.prototype.$httpAdmin.interceptors.response.use(
    response => response,
    error => {
      if (
        error &&
        error.response &&
        error.response.status &&
        error.response.status === 401 &&
        error.response.statusText === "Unauthorized"
      ) {
        localStorage.clear();
        if (!alertShowed) {
          alertShowed = true;
          Notify.create({
            type: "warning",
            message: "Sesión expirada"
          });
          router.push("/login");
        }
        return Promise.resolve(); // Avoid showing any errors
      } else if (
        error &&
        error.response &&
        error.response.data &&
        error.response.data.detailed
      ) {
        Notify.create({
          type: "error",
          message: detailed
        });
      } else {
        Notify.create({
          type: "error",
          message: "Error de servidor"
        });
      }
    }
  );
};

export { http, httpAdmin };

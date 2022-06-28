<style lang="scss">
.admin-login {
  background-color: #f0f0f0;
  min-height: 100vh;
  .login-adm {
    background-color: #002166;
    padding: 20px;
    gap: 20px;
    border-radius: 10px;
    & > div {
      border-radius: 10px;
    }
  }
}
.container {
  .login {
    width: 400px;
    border: #ccc thin solid;
    margin: auto;
    padding: 20px;
    border-radius: 10px;
  }
  .inputs {
    width: 75%;
  }
}
</style>
<template>
  <main class="cuerpo-contenido">
    <div v-if="$route.name === 'login'" class="">

        <div class="tituloPost">
          <h2 style="margin: 0;">Solicitud de salas especiales de formación</h2>
        </div>

      <div class="container q-pt-md-xl flex items-center">
        <div class="login text-center">
          <h1 class="no-margin q-pb-lg text-h6">
            Ingreso solicitud salas especiales de formación
          </h1>
          <div class="flex items-center justify-between">
            <span>Usuario </span>
            <q-input
              class="inputs"
              dense
              v-model="loginData.user"
              id="user"
              outlined
              type="text"
            />
          </div>
          <br />
          <div class="flex items-center justify-between">
            <span>Clave </span>
            <q-input
              class="inputs"
              dense
              v-model="loginData.password"
              outlined
              id="password"
              type="password"
            />
          </div>
          <br />
          <q-btn
            color="primary"
            dense
            no-caps
            class="full-width"
            icon="check"
            label="Continuar"
            @click="onClick"
            :loading="loading"
          />
        </div>
      </div>
    </div>
    <div v-else class="q-pa-lg admin-login">
      <div class="container q-pt-md-xl flex justify-center items-center">
        <div class="login-adm flex wrap text-center items-center">
          <div>
            <img src="../../assets/img/utp.png" alt="" />
            <div class="text-white">
              Solo usuarios autorizados <br />
              pueden acceder al sistema
            </div>
          </div>
          <div class="bg-white q-pa-md">
            <div class="flex items-center justify-between">
              <span>Usuario </span>
              <q-input
                class="inputs"
                dense
                v-model="loginData.user"
                id="user"
                outlined
                type="text"
              />
            </div>
            <br />
            <div class="flex items-center justify-between">
              <span>Clave </span>
              <q-input
                class="inputs"
                dense
                v-model="loginData.password"
                outlined
                id="password"
                type="password"
              />
            </div>
            <br />
            <q-btn
              color="primary"
              dense
              no-caps
              class="full-width"
              icon="check"
              label="Continuar"
              @click="onClick"
              :loading="loading"
            />
          </div>
        </div>
      </div>
    </div>
  </main>
</template>

<script>
import { http } from "boot/axios";

export default {
  name: "login",
  data() {
    return {
      loginData: {
        user: null,
        password: null,
      },
      loading: false,
    };
  },
  methods: {
    onClick() {
      this.loading = true;
      let route = this.$route.name === "login" ? "/login" : "/adm/login";
      http
        .post(route, this.loginData)
        .then(({ data }) => {
          if (data.token && data.user) {
            sessionStorage.setItem("token", data.token);
            data.user[0].correo = this.loginData.user + "@utp.edu.co";
            sessionStorage.setItem("user", JSON.stringify(data.user[0]));
            this.$router.push("/formulario");
          } else if (data.token) {
            localStorage.setItem("token", data.token);
            this.$router.push("/solicitudes/pendientes");
          }
          this.loading = false;
        })
        .catch((err) => {
          this.loading = false;
        });
    },
  },
  mounted() {},
};
</script>

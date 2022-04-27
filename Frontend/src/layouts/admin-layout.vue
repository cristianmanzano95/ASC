<style lang="scss" scoped>
.bg-blue-utp {
  background-color: #01356e;
}
.header-tabs {
  position: relative;
  min-height: 50px;
  background-color: #f8f8f8;
  padding: 0px 15px;
  border-bottom: 1px solid;
  border-color: #e7e7e7;
  div {
    padding: 15px;
    cursor: pointer;
    color: #777777;
    &:hover {
      color: #333;
    }
    a {
      color: #777777;
      &:hover {
        color: #333;
      }
    }
  }
  .active {
    background-color: #dddddd;
    color: #333;
    cursor: inherit;
    &:hover {
      color: #333;
    }
  }
}
</style>
<template>
  <q-layout view="hHh lpR fFf">
    <q-header class="text-white bg-blue-utp">
      <q-toolbar>
        <q-btn
          flat
          dense
          round
          icon="menu"
          v-if="$q.screen.lt.md"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />

        <q-toolbar-title>
          <img src="../assets/img/utp.png" alt="utp-logo" />
        </q-toolbar-title>
      </q-toolbar>
      <div class="full-width flex header-tabs">
        <q-btn
          flat
          color="grey"
          round
          icon="menu"
          v-if="$q.screen.gt.sm"
          aria-label="Menu"
          @click="leftDrawerOpen = !leftDrawerOpen"
        />
        <div class="active">Administrar solicitudes</div>
        <div>
          <a
            href="http://10.1.0.18/Aura/administracion/index.php"
            target="_blank"
          >
            Administrar salas
          </a>
        </div>
        <div @click="cerrarSesion()">Salir</div>
      </div>
    </q-header>
    <q-drawer show-if-above v-model="leftDrawerOpen" side="left" bordered>
      <div class="q-pa-sm q-mt-md">
        <q-item
          class="drawer-item"
          to="/solicitudes/pendientes"
          clickable
          v-ripple
        >
          <q-item-section avatar>
            <q-icon name="pending_actions" />
          </q-item-section>
          <q-item-section> Solicitudes pendientes </q-item-section>
        </q-item>
        <q-item
          class="drawer-item"
          to="/solicitudes/asignadas"
          clickable
          v-ripple
        >
          <q-item-section avatar>
            <q-icon name="preview" />
          </q-item-section>
          <q-item-section> Solicitudes en proceso </q-item-section>
        </q-item>
        <q-item
          class="drawer-item"
          to="/solicitudes/confirmadas"
          clickable
          v-ripple
        >
          <q-item-section avatar>
            <q-icon name="event_available" />
          </q-item-section>
          <q-item-section> Solicitudes confirmadas </q-item-section>
        </q-item>
        <q-item
          class="drawer-item"
          to="/solicitudes/rechazadas"
          clickable
          v-ripple
        >
          <q-item-section avatar>
            <q-icon name="event_busy" />
          </q-item-section>
          <q-item-section> Solicitudes rechazadas </q-item-section>
        </q-item>
      </div>
      <div class="q-pa-sm q-mt-md">
        <q-expansion-item
          class="expansion-item"
          icon="filter_alt"
          label="Filtros"
        >
          <div class="q-py-md q-px-sm">
            <q-input
              class="q-mb-md"
              v-model="filtro.documento"
              type="number"
              label="Documento de identidad"
              dense
              outlined
            />
            <q-input
              class="q-mb-md"
              v-model="filtro.correo_utp"
              type="text"
              label="Correo"
              dense
              outlined
            />
            <q-input
              class="q-mb-md"
              v-model="filtro.codigo_asignatura"
              type="text"
              label="Código asignatura"
              dense
              outlined
            />
            <q-btn
              color="primary"
              dense
              no-caps
              label="Filtrar"
              class="full-width"
              @click="filter()"
            />
            <q-btn
              color="negative"
              dense
              no-caps
              label="Borrar filtros"
              class="full-width q-mt-sm"
              @click="onReset()"
            />
          </div>
        </q-expansion-item>
      </div>
    </q-drawer>

    <q-page-container class="page-container">
      <router-view :filtro="filtro" />
    </q-page-container>
  </q-layout>
</template>

<script>
import { httpAdmin } from "boot/axios";
export default {
  data() {
    return {
      leftDrawerOpen: false,
      filtro: {
        documento: null,
        correo_utp: null,
        codigo_asignatura: null,
      },
    };
  },
  methods: {
    filter() {
      this.$events.$emit("filter");
    },
    onReset() {
      this.filtro = {
        documento: null,
        correo_utp: null,
        codigo_asignatura: null,
      };
      setTimeout(() => {
        this.$events.$emit("filter");
      }, 100);
    },
    cerrarSesion() {
      localStorage.clear();
      this.$router.push("/login-admin");
    },
  },
};
</script>

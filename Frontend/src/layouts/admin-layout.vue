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

    <main>

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

    </main>

    <!-- <q-footer class="row footer-main pt-3 pb-3" role="contentinfo" id="pie-de-pagina">

      <div class="row col-12 align-content-center footer-main__contacto mb-4">
        <h2 class="col-5 desktopShow footer-main__title">
          <strong>Contacto</strong>
        </h2>

        <div class="col-12 col-sm-7 text-end">
          <a href="https://www.facebook.com/utpereira/" aria-label="Facebook UTP" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="Facebook UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/facebookg.png" alt="facebook"></a>
          <a href="https://twitter.com/UTPereira" aria-label="Twitter UTP" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="Twitter UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/twitterg.png" alt="twitter"></a>
          <a href="https://www.youtube.com/user/utpereira" aria-label="YouTube UTP" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="YouTube UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/youtubeg.png" alt="youtube"></a>
          <a href="https://www.instagram.com/UTPereira/" aria-label="Instgram UTP" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="Instagram UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/instagramg.png" alt="instagram"></a>
          <a href="https://co.linkedin.com/school/universidad-tecnol-gica-de-pereira/" aria-label="Linkedin UTP" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="Linkedin UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/linkeding.png" alt="facebook"></a>
          <a href="https://www.utp.edu.co/atencionalciudadano/herramientas-y-ayuda.html" aria-label="Ayuda al Cuidadano" target="_blank" rel="noopener" data-bs-toogle="tooltip" title="Aplicacion Movil UTP"><img src="//media.utp.edu.co/cms/img/iconos-redes-gris/portalg.png" alt="utp"></a>
        </div>
        </div>

        <div class="col-12 col-sm-5 footer-main__contacto-info">
          <h2 class="mb-3 mobileShow footer-main__title"><strong>Contacto</strong></h2>
          <p class="mb-0"><strong>Llámanos:</strong></p>
          <p class="mb-0">Teléfono: +57 606 3137141 Fax: :  3137107</p>
          <p class="mb-0">Conmutador: (57) 606 313 7300</p>
          <br>
          <p class="mb-0">Correo: <a href="mailto:contactenos@utp.edu.co?Subject=Correo%20de%20contacto%20"><strong>contactenos@utp.edu.co</strong></a></p>
          <br>
          <p class="mb-0"><strong>Dirección:</strong></p>
          <p class="mb-0">Recursos Informáticos y Educativos - CRIE</p>
          <p class="mb-0">Carrera 27 #10-02 Barrio Álamos Pereira, Risaralda</p>
          <p class="mb-0">Edificio 3 - Oficina 307</p>
        </div>


        <div class="col-12 col-sm-7 generalInfo">
          <p> © 2022 - <a href="//www.utp.edu.co" aria-label="Portal UTP"></a>Universidad Tecnológica de Pereira - <a href="//www.utp.edu.co/acreditacion/historia-de-la-acreditacion-utp.html" aria-label="Leer Acreditacion">Reacreditada institucionalmente en 2021, con vigencia de 10 años </a>- Sujeta a inspección y vigilancia</p>
          <br>
          <p>Carrera 27 #10-02 Barrio Álamos - Risaralda - Colombia - AA: 97 - Código postal: 660003 - <a href="//www.utp.edu.co/registro/19/ceres" aria-label="Leer Ceres">CERES</a><br></p>
          <br>
          <p>PBX: +57 606 3137300 - Fax: +57 6 3213206 - Línea gratuita de Quejas y Reclamos: 018000966781 - <b><a href="mailto:contactenos@utp.edu.co?Subject=Correo%20de%20contacto%20" style="color:#000000">contactenos@utp.edu.co</a></b></p>
          <p><b>Horario de atención:</b> Lunes a Viernes de 8:00am a 12:00m y de 2:00pm a 6:00pm</p>
          <br>
          <p>Institución de Educación Superior vigilada por <a href="https://www.mineducacion.gov.co/portal/" aria-label="Ministeria de Educación">MinEducación</a></p>
          <p><a href="//www.utp.edu.co/cms-utp/data/bin/UTP/web/uploads/media/calidad/archivos/1313-MGD-01_V4_Manual_General_de_Directrices_del_SGSI.pdf" aria-label="Leer Politicas">Políticas de Seguridad de la Información</a> - <a href="//www.utp.edu.co/secretaria/informacion-general/678/notificaciones-judiciales" aria-label="Leer Notificacion">Notificaciones Judiciales</a></p>
          <br>
          <p>Desarrollado por: <a href="//crie.utp.edu.co/desarrollo-web" aria-label="Ir a pagina del crie">Recursos Informáticos y Educativos, Desarrollo y Administración Web UTP</a></p>
        </div>
      </q-footer> -->

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

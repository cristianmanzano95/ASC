<style scoped>
</style>
<template>
  <div>
    <!-- ===================================================================================================================================================== -->
    <header id="header">

          <!-- sección del banner superior -->
      <section class="row col-12 items-center content-around row_cabecera">
        <!--Menu desplegable parte superior izquierda-->
        <div class="col-1 desktop-hide">
            <q-btn-dropdown color="grey-5" icon="menu">
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('Inicio')">
                  <q-item-section>
                    <q-item-label><a href="https://www.utp.edu.co/">Inicio</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Accesibilidad')">
                <q-item-section>
                  <q-item-label><a href="https://www.utp.edu.co/principal/accesibilidad.php">Accesibilidad</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
             <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Mapa del Sitio')">
                <q-item-section>
                  <q-item-label><a href="https://www.utp.edu.co/principal/mapa.php">Mapa del Sitio</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Atención al Ciudadano')">
                <q-item-section>
                  <q-item-label><a href="https://www.utp.edu.co/atencionalciudadano/">Atención al Ciudadano</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('PQRS')">
                <q-item-section>
                  <q-item-label><a href="https://pqrs.utp.edu.co/">PQRS</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Correo')">
                <q-item-section>
                  <q-item-label><a href="https://www.utp.edu.co/correo">Correo</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('RSS')">
                <q-item-section>
                  <q-item-label><a href="https://www.utp.edu.co/feed.php">RSS</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            </q-btn-dropdown>
        </div>

          <!-- logo de la UTP -->

        <section class="row col-sm-3 text-center text-sm-start logo-titulo ">
            <!-- contenedor img -->
          <div class="row items-center col-12 titulo">
            <a class="subrayado" href="http://www.utp.edu.co/" rel="noopener norreferer" title="UTP" target="_blank">
              <img src="https://crie.utp.edu.co/wp-content/themes/crie/img/logoutp.png" title="Universidad Tecnológica de Pereira" alt="Logo Universidad Tecnológica de Pereira" class="logo" style="margin-left: 1rem;">
            </a>
            <!-- linea vertical -->
            <div class="d-none d-sm-block vl col-1 ms-4"></div>
            <!-- fin linea -->

            <!-- texto facultades -->
            <div class="col-sm-5 d-none d-sm-block text-start q-ml-sm" style="text-align: left; margin-left: 1.5rem;">
              <a href="https://crie.utp.edu.co">
                <span class="tituloSup">CRIE</span>
              </a>
            </div>
            <!-- fin texto facultades -->
          </div>
          <!-- fin img -->
        </section>

          <!-- menu superior -->
      <section class="col-sm-7">
        <q-bar class=" menu-institucional" style="align-items: center; justify-content: center; ">
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/">Inicio</a></div>
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/principal/accesibilidad.php">Accesibilidad</a></div>
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/principal/mapa.php">Mapa del Sitio</a></div>
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/atencionalciudadano/">Atención al Ciudadano</a></div>
          <div class="cursor-pointer"><a href="https://pqrs.utp.edu.co/">PQRS</a></div>
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/correoprueba">Correo</a></div>
          <div class="cursor-pointer"><a href="https://www.utp.edu.co/feed.php">RSS</a></div>
        </q-bar>
      </section>
        <!-- logo del ministerio de educación -->
        <section class="col-6 col-sm-2 text-end logo-ministerio">
          <a href="https://www.mineducacion.gov.co/" rel="noopener norreferer" title="Ministerio de Educación" target="_blank">
            <img src="https://crie.utp.edu.co/wp-content/themes/crie/img/ministerioeducacion.png" title="Ministerio de Educación" alt="Ministerio de Educación de Colombia" class="logo2">
          </a>
        </section>

          <!-- </div> -->

      </section>
        <!-- fin sección del banner superior -->
        <!-- sección del slider que se muestra en la página principal. -->
      <section class="sliderprincipal">
        <div class="slider1">
          <!-- sección del slider que se muestra en la página principal. -->
          <section class="imagen-banner">
            <img src="https://crie.utp.edu.co/wp-content/themes/crie/img/cabecera-principal.jpg" title="Universidad Tecnológica de Pereira">
          </section>
        </div>
        <!-- fin sección del slider que se muestra en la página principal -->

        <div class="titulositio">
          <h1>Recursos Informáticos y Educativos</h1>
        </div>
      </section>
        <!-- fin sección del slider que se muestra en la página principal -->
      <section class="col-12 row align-items-center menu-institucional">
        <div class="col-7 d-lg-none mobile-only desktop-hide">
          <q-btn-dropdown color="grey-5" icon="menu">
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('Inicio')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/">Inicio</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('CRIE')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/crie/">CRIE</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('Noticias')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/noticias/">Noticias</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('Contáctenos')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/contactenos/">Contáctenos</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('Servicios')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/servicios/">Servicios</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
              <q-list>
                <q-item clickable v-close-popup @click="onItemClick('CRIEin')">
                  <q-item-section>
                    <q-item-label><a href="https://crie.utp.edu.co/category/criein/">CRIEin</a></q-item-label>
                  </q-item-section>
                </q-item>
              </q-list>
          </q-btn-dropdown>
        </div>
        <div class="col-10 col-xl-9 d-none d-lg-block mobile-hide desktop-only">
          <q-bar class=" menu-institucional">
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Inicio')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/">Inicio</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('CRIE')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/crie/">CRIE</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Noticias')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/noticias/">Noticias</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Contáctenos')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/contactenos/">Contáctenos</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('Servicios')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/servicios/">Servicios</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
            <q-list>
              <q-item clickable v-close-popup @click="onItemClick('CRIEin')">
                <q-item-section>
                  <q-item-label><a href="https://crie.utp.edu.co/category/criein/">CRIEin</a></q-item-label>
                </q-item-section>
              </q-item>
            </q-list>
          </q-bar>
        </div>
        <div class="col-2 col-xl-3 mobile-hide desktop-only q-my-sm">
          <!--  -->

        <!-- <q-form class="row buscador">
          <q-input outlined bg-color="white" placeholder="Busqueda">

          </q-input>
          <q-btn icon="search" bg-color="primary"></q-btn>
        </q-form> -->
        <!-- --------------------------Buscador arriba uwu------------------------ -->
        <div class="col-12">
          <form role="search" id="cse-search-box" method="get" class=" input-group input-group-sm" action="https://crie.utp.edu.co/">
            <div style="width: 90%;">
              <input name="ie" value="UTF-8" type="hidden">
              <input class="form-control no-border-radius" type="search" aria-label="Google Search" placeholder="Busqueda" value="" name="s">
            </div>

            <button class="input-group-text bi btn-primary bi-search rounded-end" aria-label="Buscador" aria-hidden="false" style="padding-bottom: 0; border-bottom-width: 0px;"></button>

            <input id="buscar" name="siteurl" value="www.utp.edu.co/" type="hidden">
          </form>
        </div>
        </div>
        <div class="col-5 mobile-only desktop-hide">
          <form role="search" id="cse-search-box" method="get" class="input-group input-group-sm" action="https://crie.utp.edu.co/">
            <label class="sr-only">
                <span class="d-none screen-reader-text">Buscar:</span>
            </label>
            <input name="ie" value="UTF-8" type="hidden">
            <input class="form-control" type="search" aria-label="Google Search" placeholder="Busqueda" value="" name="s">
            <button class="input-group-text bi btn-primary bi-search rounded-end" aria-label="Buscador" aria-hidden="false"></button>
            <input id="buscar" name="siteurl" value="www.utp.edu.co/" type="hidden">
          </form>
        </div>
      </section>
	  </header>

    <!-- fin cabecera para Postgrados-->
    <!-- ======================================================================================================================= -->
  <main id="contenido" class="cuerpo-contenido">

	  <div class="">
      <div class="row cuerpo">
        <div class="hidden-print col-lg-12 col-md-12 my-4">
          <ol class="breadcrumb">
            <li>
              <a
                href="https://crie.utp.edu.co/"
                title="pagina de inicio"
                >Inicio</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/servicios/salas-especiales-de-formacion/" title="Salas"
                >Salas</a
              >
            </li>
            <li class="active">Solicitud sala especial de formación</li>
          </ol>
        </div>

        <!-- Menu Contenido Izquierdo -->


        <!-- Fin Menu Contenido Izquierdo-->

        <!-- Contenido Noticias -->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <router-view />
        </div>
      </div>
    </div>

      <!-- ==================================================================================================================================================== -->
      <!-- fin del content -->
  </main>


      <!-- pie de página -->
      <!-- ==================================================================================================================================================== -->
      <!-- Menú inferior-->
      <!-- <div class="row text-center menu_inferior_plantilla hidden-print">
        <a href="https://crie.utp.edu.co/inicio.html" title="Inicio">Inicio</a>
        <a href="https://www.utp.edu.co/" title="Página Principal"
          >Universidad Tecnológica de Pereira</a
        >
        <a href="https://crie.utp.edu.co/contacto.html" title="Contáctenos"
          >Contáctenos</a
        >
        <a href="https://crie.utp.edu.co/mapa.html" title="Mapa del Sitio"
          >Mapa del Sitio</a
        >
      </div> -->
      <!--Fin Menú inferior-->

  <footer class="row footer-main pt-3 pb-3" role="contentinfo" id="pie-de-pagina">

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
	</footer>
      <!-- ===================================================================================================================================================== -->
      <!-- fin pie de página -->
    </div>

    <!-- ===================================================================================================================================================== -->
    <!-- fin del menu responsive superior-->

</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>

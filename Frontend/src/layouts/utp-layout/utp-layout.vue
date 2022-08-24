<style scoped>
</style>
<template>
  <div>
    <!-- ===================================================================================================================================================== -->
    <div class="row">
      <div class="row col-12 items-center content-around">
        <!-- se hace el llamado al slider y al menú de cada facultad -->

        <!-- éste include llama al archivo seccion_superior donde esta la cabecera de los sitios -->
        <div class="header col-12 container_principal">
          <div class="row row_cabecera">

            <!-- Desplegable parte superior -->
            <div class="col-2 hidden-md">
              <q-btn-dropdown class="" color="grey-4" icon="menu">
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
          <!-- Desplegable parte superior -->


            <div class="container_cabecera row col-xxl-3 col-5">

              <div class="row col-12 titulo-izq" >
                <div class="img-izq-sup">
                  <a
                    href="https://www.utp.edu.co/"
                    title="Universidad Tecnológica de Pereira"
                    accesskey="1"
                  >
                    <img
                      src="https://media2.utp.edu.co/imagenes/logoutp.png"
                      id="img-izq-sup"
                      alt="Escudo Universidad Tecnologica de Pereira"
                      class="img-responsive margin-right-minE "
                    />
                  </a>
                </div>
                <!-- Linea vertical -->
                <div class=" vl hidden-xs">
                </div>

                <div class="">

                    <a class="" href="https://crie.utp.edu.co/inicio.html">
                      <!-- las limeas siguientes acomoda el título en ´partes y puede ser llamado desde cuanquier parte de plantillaPosgrados -->
                      <span class="tituloIup hidden-xs" style="">CRIE</span>
                    </a>
                  </div>
              </div>

            </div>


          <!-- Menu superior -->
              <nav class="menu_superior col-xxl-6 hidden-sm">
                <ul class="menu_principal_facul hidden-xs ">
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/inicio.html">Inicio</a>
                  </li>
                  <li>
                    <a class="nav-link" href="https://www.utp.edu.co/principal/accesibilidad.php"
                      >Accesibilidad</a
                    >
                  </li>
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/mapa.html"
                      >Mapa del Sitio</a
                    >
                  </li>
                  <li>
                    <a class="nav-link" href="https://www.utp.edu.co/atencionalciudadano/"
                      >Atención al Ciudadano</a
                    >
                  </li>
                  <li><a class="nav-link" href="https://pqrs.utp.edu.co/">PQRS</a></li>
                  <li>
                    <a
                      class="nav-link" href="https://accounts.google.com/signin/v2/identifier?continue=http%3A%2F%2Fmail.google.com%2Fa%2Futp.edu.co&amp;ltmpl=default&amp;hd=utp.edu.co&amp;service=mail&amp;sacu=1&amp;rip=1&amp;flowName=GlifWebSignIn&amp;flowEntry=ServiceLogin"
                      >Correo</a
                    >
                  </li>
                  <li><a class="nav-link" href="https://www.utp.edu.co/feed.php">RSS</a></li>
                </ul>
              </nav>
              <!-- fin menu superior -->

              <div class="escudo_facul col-xxl-3 col-5">
                <a
                  href="https://www.mineducacion.gov.co/1621/w3-channel.html"
                  title="Ministerio de Educacion"
                  accesskey="2"
                >
                  <img
                    src="https://media2.utp.edu.co/imagenes/ministerioeducacion.png"
                    alt="Ministerio de Educación"
                    class="logo-derecha"
                  />
                </a>
              </div>

          </div>

          <!-- Banner -->
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

          <!-- END Banner -->


          <!-- <div id="sliderPosgrados">
             Verifica si la cantidad de imagenes es mayor o igual a 1 -->

            <!-- <div class="row row_carrusel">
              <div
                class="slider-facultad col-xs-12 col-sm-12 col-md-12 col-lg-12"
              >
                <div
                  id="carousel-banner"
                  class="carousel carousel-banner slide"
                > -->
                  <!-- Imágenes -->
                  <!-- <div class="slider-fac">
                      <img class="img-responsive item slider-fac"
                        src="https://crie.utp.edu.co/wp-content/themes/crie/img/cabecera-principal.jpg" title="Universidad Tecnológica de Pereira">
                  </div>
                </div>
              </div>
            </div> -->
          <!-- </div> -->
        </div>
      </div>
    </div>

    <!-- menu parte inferior -->
    <div class="row menu-nav color-back-menuInf ">
      <div class=" col-12 ribbon-facultades hidden-print row">
        <div class="menu-nav col-9 col-xss-7">
          <nav class="menu_superior hidden-sm ">
                <ul class="menu_principal_nav hidden-xs ">
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/inicio.html">Inicio</a>
                  </li>
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/crie/"
                      >CRIE</a
                    >
                  </li>
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/noticias/"
                      >Noticias</a
                    >
                  </li>
                  <li>
                    <a class="nav-link" href="https://crie.utp.edu.co/contactenos/"
                      >Contáctenos</a
                    >
                  </li>
                  <li><a class="nav-link" href="https://crie.utp.edu.co/servicios/">Servicios</a></li>
                  <li><a class="nav-link" href="https://crie.utp.edu.co/category/criein/">CRIEin</a></li>
                </ul>
              </nav>
        <!-- fin menu parte inferior -->


          <!-- Desplegable parte inferior -->
            <div class="col-12 color-back-menuInf">
              <q-btn-dropdown class="without-icon hidden-xl despl-menu-inf hidden-md " color="var(--institucional)" icon="menu">
                <q-list>
                  <q-item clickable v-close-popup @click="onItemClick('Inicio')">
                    <q-item-section>
                      <q-item-label><a href="https://www.utp.edu.co/">Inicio</a></q-item-label>
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

          <!--Menu Desplegable parte inferior -->
        </div>
        <!-- Buscador segundo menu -->
        <div class="buscador-facul col-3 col-xss-5">

            <form role="search" id="cse-search-box" method="get" class="buscador-boton input-group input-group-sm busqueda-down" action="https://crie.utp.edu.co/">
              <input name="ie" value="UTF-8" type="hidden">
              <input class="form-control no-border-radius" type="search" aria-label="Google Search" placeholder="Busqueda" value="" name="s">
              <button class="fs-1 input-group-text bi btn-primary bi-search rounded-end" aria-label="Buscador" aria-hidden="false" style="padding-bottom: 0; border-bottom-width: 0px;"></button>
              <input id="buscar" name="siteurl" value="www.utp.edu.co/" type="hidden">
            </form>

        </div>
      </div>
    </div>









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
                >Inicio
              </a>
            </li>
            <!-- <li>
              <a href="https://crie.utp.edu.co/servicios/salas-especiales-de-formacion/" title="Salas"
                >Salas</a
              >
            </li> -->
            <li class="active">Solicitud sala especial de formación</li>
          </ol>
        </div>

        <!-- Contenido Noticias -->
        <div class="col-xs-12">
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
        <p class="mb-0">Correo: <a href="mailto:admsalas@utp.edu.co?Subject=Correo%20de%20contacto%20"><strong>admsalas@utp.edu.co</strong></a></p>
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

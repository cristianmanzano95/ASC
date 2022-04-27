<style scoped>
</style>
<template>
  <div>
    <!-- ===================================================================================================================================================== -->
    <div class="row cabecera">
      <div class="slider-facultades col-md-12 col-lg-12 hidden-print">
        <!-- se hace el llamado al slider y al menú de cada facultad -->

        <!-- éste include llama al archivo seccion_superior donde esta la cabecera de los sitios -->
        <div class="header container_principal">
          <div class="row row_cabecera hidden-xs hidden-sm">
            <div class="container_cabecera row">
              <div class="img-izq-sup col-lg-1 col-md-1">
                <a
                  href="https://www.utp.edu.co/"
                  title="Universidad Tecnológica de Pereira"
                  accesskey="1"
                >
                  <img
                    src="../../assets/img/utp-150.png"
                    id="img-izq-sup"
                    alt="Escudo Universidad Tecnologica de Pereira"
                    class="img-responsive"
                  />
                </a>
              </div>

              <div class="prograPosgrados col-lg-2 col-md-2">
                <div
                  class="
                    prograPosgradosLetra
                    col-lg-12 col-md-12 col-sm-12 col-xs-12
                  "
                >
                  <a class="" href="https://crie.utp.edu.co/inicio.html">
                    <!-- las limeas siguientes acomoda el título en ´partes y puede ser llamado desde cuanquier parte de plantillaPosgrados -->
                    <div class="tituloSup" style="">Recursos Informáticos</div>
                    <div class="tituloIup" style="">y Educativos - CRIE</div>
                  </a>
                </div>
              </div>

              <nav class="menu_superior col-lg-7 col-md-7">
                <ul class="menu_principal_facul">
                  <li>
                    <a href="https://crie.utp.edu.co/inicio.html">Inicio</a>
                  </li>
                  <li>
                    <a href="https://www.utp.edu.co/principal/accesibilidad.php"
                      >Accesibilidad</a
                    >
                  </li>
                  <li>
                    <a href="https://crie.utp.edu.co/mapa.html"
                      >Mapa del Sitio</a
                    >
                  </li>
                  <li>
                    <a href="https://www.utp.edu.co/atencionalciudadano/"
                      >Atención al Ciudadano</a
                    >
                  </li>
                  <li><a href="https://pqrs.utp.edu.co/">PQRs</a></li>
                  <li>
                    <a
                      href="https://accounts.google.com/signin/v2/identifier?continue=http%3A%2F%2Fmail.google.com%2Fa%2Futp.edu.co&amp;ltmpl=default&amp;hd=utp.edu.co&amp;service=mail&amp;sacu=1&amp;rip=1&amp;flowName=GlifWebSignIn&amp;flowEntry=ServiceLogin"
                      >Correo</a
                    >
                  </li>
                  <li><a href="https://www.utp.edu.co/feed.php">RSS</a></li>
                </ul>
              </nav>

              <div class="escudo_facul col-lg-2 col-md-2">
                <a
                  href="https://www.mineducacion.gov.co/1621/w3-channel.html"
                  title="Ministerio de Educacion"
                  accesskey="2"
                >
                  <img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/ministerioeducacion2(1).png"
                    alt="Ministerio de Educación"
                    class="img-responsive"
                  />
                </a>
              </div>
            </div>
          </div>

          <div id="sliderPosgrados">
            <!-- Verifica si la cantidad de imagenes es mayor o igual a 1 -->

            <div class="row row_carrusel">
              <div
                class="slider-facultad col-xs-12 col-sm-12 col-md-12 col-lg-12"
              >
                <div
                  id="carousel-banner"
                  class="carousel carousel-banner slide"
                >
                  <!-- Imágenes -->
                  <div class="carousel-inner slider-fac">
                    <div class="item active">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/_JCM2752Banner.jpg"
                      />
                    </div>

                    <!-- <div class="item">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/banner.jpg"
                      />
                    </div>

                    <div class="item">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/banner1.jpg"
                      />
                    </div>

                    <div class="item">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/Banner-Programas-academicos50.jpg"
                      />
                    </div>

                    <div class="item">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/DJI_0011Banner.jpg"
                      />
                    </div>

                    <div class="item">
                      <img
                        class="img-responsive"
                        src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/_JCM2754Banner.jpg"
                      />
                    </div> -->
                  </div>

                  <a
                    class="left carousel-control"
                    href="https://crie.utp.edu.co/crie/reserva#carousel-banner"
                    data-slide="prev"
                  >
                    <span class="glyphicon glyphicon-chevron-left"></span>
                  </a>
                  <a
                    class="right carousel-control"
                    href="https://crie.utp.edu.co/crie/reserva#carousel-banner"
                    data-slide="next"
                  >
                    <span class="glyphicon glyphicon-chevron-right"></span>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row menu_nav hidden-xs hidden-sm">
      <div class="ribbon-facultades hidden-print row">
        <div class="menu-nav col-lg-8 col-md-8">
          <ul class="menu_navegacion_facul">
            <li><a href="https://crie.utp.edu.co/inicio.html">Inicio</a></li>
            <li>
              <a href="https://www.utp.edu.co/inscripciones/">Inscripciones</a>
            </li>
            <li>
              <a href="https://www.utp.edu.co/portal/facultades/">Facultades</a>
            </li>
            <li>
              <a href="https://www.utp.edu.co/portal/inicio">La Universidad</a>
            </li>
            <li>
              <a href="https://www.utp.edu.co/institucional/utp-virtual/">UTP Virtual</a
              >
            </li>
            <li>
              <a href="https://www.utp.edu.co/portal/servicios/">Servicios</a>
            </li>
            <li>
              <a href="https://www.utp.edu.co/internacional/">Internacional</a>
            </li>
            <li><a href="https://biblioteca.utp.edu.co/">Biblioteca</a></li>
          </ul>
        </div>

        <div class="buscador-facul col-lg-4 col-md-4">
          <form
            class="input-group input-group-sm"
            role="search"
            action="https://crie.utp.edu.co/crie/busquedas.html"
            method="GET"
            id="cse-search-box"
          >
            <label for="buscar" style="display: none">Buscar</label>
            <input
              type="hidden"
              name="cx"
              value="016308424957665409789:f36jprwbdtw"
            />
            <input type="hidden" name="cof" value="FORID:10" />
            <input type="hidden" name="ie" value="UTF-8" />
            <input type="text" class="form-control" id="buscar" name="q" />
            <span class="input-group-btn">
              <button
                class="btn btn-primary btn-buscar"
                name="sa"
                type="submit"
              >
                <q-icon name="search" />
              </button>
            </span>
            <input type="hidden" name="siteurl" value="www.utp.edu.co/" />
          </form>
        </div>
      </div>
    </div>

    <!-- fin cabecera para Postgrados-->
    <!-- ======================================================================================================================= -->

    <div class="cuerpo-contenido">
      <div class="row cuerpo">
        <div class="hidden-print col-lg-12 col-md-12">
          <ol class="breadcrumb">
            <li>
              <a
                href="https://crie.utp.edu.co/inicio.html"
                title="pagina de inicio"
                >Inicio</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/salas.html" title="Salas"
                >Salas</a
              >
            </li>
            <li class="active">Solicitud sala especial de formación</li>
          </ol>
        </div>

        <!-- Menu Contenido Izquierdo -->

        <div
          class="
            col-lg-3 col-md-3
            hidden-sm hidden-xs
            menu_lateral_inicio
            hidden-print
          "
        >
          <ul
            id="accordion"
            class="
              accordion
              nav nav-list nav-department nav-tabs nav-stacked
              menu_lateral
            "
          >
            <li>
              <a href="https://crie.utp.edu.co/quienes-somos.html"
                >¿Quienes Somos?</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/funcionarios.html"
                >Quiénes hacen parte de ella</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/direccion.html">Dirección</a>
            </li>
            <li>
              <a href="https://crie.utp.edu.co/academia-cisco.html"
                >Academia Cisco</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/capacitacion.html"
                >Capacitación</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/desarrollo-web.html"
                >Desarrollo Web</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/diseno-grafico.html"
                >Diseño Gráfico</a
              >
            </li>
            <li><a href="https://crie.utp.edu.co/red.html">Red</a></li>
            <li><a href="https://crie.utp.edu.co/salas.html">Salas</a></li>
            <li><a href="http://crie.utp.edu.co/television/">Televisión</a></li>
            <li>
              <a href="https://crie.utp.edu.co/gestion-calidad.html"
                >Gestión Calidad</a
              >
            </li>
            <li>
              <a href="https://crie.utp.edu.co/contacto.html">Contáctenos</a>
            </li>
            <li>
              <a href="https://crie.utp.edu.co/lineamientos-y-politicas.html"
                >Lineamientos y Políticas</a
              >
            </li>
            <li>
              <a href="https://imageneidentidad.utp.edu.co/" target="_blank"
                >Centro Virtual de Imagen e identidad UTP</a
              >
            </li>
            <!-- <li><a href="https://crie.utp.edu.co/crie/firma.html" >Generador de Firmas</a></li> -->
            <li>
              <a href="https://crie.utp.edu.co/portal-utp.html">Portal UTP</a>
            </li>
            <li>
              <a href="https://crie.utp.edu.co/criein.html">Noticias CRIEin</a>
            </li>
          </ul>
        </div>
        <!-- Fin Menu Contenido Izquierdo-->

        <!-- Contenido Noticias -->
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
          <router-view />
        </div>
      </div>

      <!-- ==================================================================================================================================================== -->
      <!-- fin del content -->

      <!-- pie de página -->
      <!-- ==================================================================================================================================================== -->
      <!-- Menú inferior-->
      <div class="row text-center menu_inferior_plantilla hidden-print">
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
      </div>
      <!--Fin Menú inferior-->

      <footer>
        <div class="container informacion_pie">
          <div class="container hidden-print">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row-redes">
                <a
                  href="https://www.facebook.com/utpereira/"
                  aria-label="Facebook UTP"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="Facebook UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/facebookg.png"
                    alt="facebook"
                /></a>
                <a
                  href="https://twitter.com/UTPereira"
                  aria-label="Twitter UTP"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="Twitter UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/twitterg.png"
                    alt="twitter"
                /></a>
                <a
                  href="https://www.youtube.com/user/utpereira"
                  aria-label="YouTube UTP"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="YouTube UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/youtubeg.png"
                    alt="youtube"
                /></a>
                <a
                  href="https://www.instagram.com/UTPereira/"
                  aria-label="Instgram UTP"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="Instagram UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/instagramg.png"
                    alt="instagram"
                /></a>
                <a
                  href="https://co.linkedin.com/school/universidad-tecnol-gica-de-pereira/"
                  aria-label="Linkedin UTP"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="Linkedin UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/linkeding.png"
                    alt="facebook"
                /></a>
                <a
                  href="https://www.utp.edu.co/atencionalciudadano/herramientas-y-ayuda.html"
                  aria-label="Ayuda al Cuidadano"
                  target="_blank"
                  rel="noopener"
                  data-toggle="tooltip"
                  title="Aplicacion Movil UTP"
                  ><img
                    src="./Recursos Informáticos y Educativos CRIE __ Solicitud Sala de Cómputo Para Docentes_files/portalg.png"
                    alt="utp"
                /></a>
              </div>
            </div>
            <div class="row">
              <div
                class="
                  col-xs-12 col-sm-4 col-md-4 col-lg-4
                  informacion-contacto
                "
              >
                <strong class="texto-pie">Contacto</strong><br /><br />
                Llámanos<br />
                Tel: +57 6 3137141 Fax: 3137107<br />
                Conmutador: (57) (6) 313 7300 <br /><br />
                Correos:<br />
                <a href="mailto:contactenos@utp.edu.co"
                  >contactenos@utp.edu.co</a
                ><br /><br />
                Dirección<br />
                Recursos Informáticos y Educativos - CRIE<br />
                Carrera 27 #10-02 Barrio Álamos Pereira, Risaralda<br />
                Edificio 3 - oficina 307
              </div>
              <div
                class="
                  col-xs-12 col-sm-8 col-md-8 col-lg-8
                  informacion-institucional
                "
              >
                <br /><br />
                © 2020 -
                <strong class="texto-pie"
                  >Universidad Tecnológica de Pereira</strong
                >
                -
                <a
                  href="https://www.utp.edu.co/acreditacion/historia-de-la-acreditacion-utp.html"
                  aria-label="Leer Acreditacion"
                  >Reacreditada institucionalmente en 2021, con vigencia de 10
                  años</a
                >
                - Sujeta a inspección y vigilancia<br />
                <br />Carrera 27 #10-02 Barrio Álamos - Risaralda - Colombia -
                AA: 97 - Código postal: 660003 -
                <a
                  href="https://www.utp.edu.co/registro/19/ceres"
                  aria-label="Leer Ceres"
                  >CERES</a
                ><br />
                <br />PBX: +57 6 3137300 - Fax: +57 6 3213206 - Línea gratuita
                de Quejas y Reclamos: 018000966781 -
                <strong
                  >contactenos<span style="display: none">null</span>@<span
                    style="display: none"
                    >null</span
                  >utp.<span style="display: none">null</span>edu.co</strong
                ><br />
                <br /><strong class="texto-pie">Horario de atención:</strong>
                Lunes a Viernes de 8:00am a 12:00m y de 2:00pm a 6:00pm<br />
                <br />Institución de Educación Superior vigilada por
                MinEducación<br />
                <a
                  href="https://www.utp.edu.co/cms-utp/data/bin/UTP/web/uploads/media/calidad/archivos/1313-MGD-01_V4_Manual_General_de_Directrices_del_SGSI.pdf"
                  aria-label="Leer Politicas"
                  >Políticas de Seguridad de la Información</a
                >
                -
                <a
                  href="https://www.utp.edu.co/secretaria/informacion-general/678/notificaciones-judiciales"
                  aria-label="Leer Notificacion"
                  >Notificaciones Judiciales</a
                ><br /><br />

                Desarrollado por:
                <a
                  href="https://crie.utp.edu.co/desarrollo-web"
                  aria-label="Ir a pagina del crie"
                  >Recursos Informáticos y Educativos, Desarrollo y
                  Administración Web UTP</a
                >
              </div>
            </div>
          </div>
        </div>
      </footer>
      <!-- ===================================================================================================================================================== -->
      <!-- fin pie de página -->
    </div>

    <!-- ===================================================================================================================================================== -->
    <!-- fin del menu responsive superior-->
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },
};
</script>

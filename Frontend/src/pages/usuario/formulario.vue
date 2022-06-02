<style lang="scss" scoped>
.logout {
  text-align: right;
  span {
    font-size: 12px;
    color: grey;
    cursor: pointer;
    &:hover {
      text-decoration: underline;
      color: $primary;
    }
  }
}
.textForm {
  margin: auto 0;
}
.formGrid {
  display: grid;
  grid-template-columns: 1fr 1fr 1fr;
  gap: 10px;
}
.separator {
  width: 100%;
  height: 1px;
}
.user-info {
  display: flex;
  padding: 10px;
  flex-direction: column;
  gap: 10px;
}
.scheduleGrid {
  display: grid;
  grid-template-areas:
    "day day1"
    "time1 time2";
  grid-gap: 10px;
  .day {
    grid-area: day;
  }
  .time1 {
    grid-area: time1;
  }
  .time2 {
    grid-area: time2;
  }
}
.scheduleText {
  min-width: 130px;
  transform: translateY(-10px);
}
.scheduleSelect {
  width: 100%;
}
.formBtn {
  & > button {
    width: 100px;
  }
}
.seeMore {
  display: inline-block;
  cursor: pointer;
}

.seeMore::after {
  content: "";
  width: 0px;
  height: 1px;
  display: block;
  background: black;
  transition: 300ms;
}
.manual_input {
  text-decoration: underline;
  font-weight: bold;
  cursor: pointer;
  &:hover {
    color: $primary;
  }
}

.seeMore:hover::after {
  width: 100%;
}
@media (max-width: $breakpoint-sm-max) {
  .formContainer {
    border-left: none;
    border-top: thin solid #ccc;
    margin-top: 20px;
  }
}
@media (max-width: $breakpoint-sm-min) {
  .formGrid {
    grid-template-columns: 1fr;
  }
}
</style>
<template>
  <div id="first" v-if="reset" class="container q-px-md">
    <div class="articulo">
      <div class="titulo">
        <h2>Solicitud de salas especiales de formación</h2>
      </div>
    </div>
    <div class="logout">
      <span @click="cerrarSesion()">Cerrar sesión</span>
    </div>
    <div
      v-if="userRequests && userRequests.length > 0 && !edit"
      class="q-mb-md relative-position"
    >
      <h1 class="text-h5 no-margin q-pb-md">Solicitudes realizadas</h1>
      <div class="full-width text-right q-pb-md">
        <q-btn-dropdown class="" color="grey" no-caps label="Filtrar">
          <div class="row no-wrap q-pa-md">
            <div class="column">
              <q-input
                class="q-mb-md"
                v-model="filtro.codigo_asignatura"
                type="text"
                label="Código asignatura"
                dense
                outlined
              />
              <q-input
                outlined
                dense
                label="Fecha inicio de solicitud"
                v-model="filtro.fecha_solicitud_inicio"
                mask="date"
                :rules="['date']"
              >
                <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy
                      ref="qDateProxy"
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-date v-model="filtro.fecha_solicitud_inicio">
                        <div class="row items-center justify-end">
                          <q-btn
                            v-close-popup
                            label="Cerrar"
                            color="primary"
                            flat
                          />
                        </div>
                      </q-date>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
              <q-input
                outlined
                dense
                label="Fecha fin de solicitud"
                v-model="filtro.fecha_solicitud_fin"
                mask="date"
                :rules="['date']"
              >
                <template v-slot:append>
                  <q-icon name="event" class="cursor-pointer">
                    <q-popup-proxy
                      ref="qDateProxy"
                      transition-show="scale"
                      transition-hide="scale"
                    >
                      <q-date v-model="filtro.fecha_solicitud_fin">
                        <div class="row items-center justify-end">
                          <q-btn
                            v-close-popup
                            label="Cerrar"
                            color="primary"
                            flat
                          />
                        </div>
                      </q-date>
                    </q-popup-proxy>
                  </q-icon>
                </template>
              </q-input>
              <q-select
                v-model="filtro.tipo_formulario"
                dense
                label="Tipo de sala"
                outlined
                class="q-mb-md"
                map-options
                emit-value
                :options="$tipo_salas"
              />
              <q-btn
                color="primary"
                dense
                no-caps
                label="Filtrar"
                class="full-width"
                @click="getPagination()"
              />
              <q-btn
                color="negative"
                dense
                v-close-popup
                no-caps
                label="Borrar filtros"
                class="full-width q-mt-sm"
                @click="onResetFilter()"
              />
            </div>
          </div>
        </q-btn-dropdown>
      </div>
      <div class="formGrid">
        <q-card
          v-for="(solicitud, index) in userRequests"
          :key="index"
          class="my-card q-mb-md"
        >
          <q-card-section>
            <div class="text-h6 text-capitalize">
              {{ solicitud.nombre_asignatura }}
            </div>
            <div class="text-subtitle2 text-uppercase">
              {{ solicitud.codigo_asignatura }}
            </div>
          </q-card-section>
          <q-card-section class="q-pt-none row">
            <div class="col-9">
              <div class="text-subtitle2">
                Estado:
                <span :class="'text-' + estados_dic[solicitud.estado].color">{{
                  estados_dic[solicitud.estado].label
                }}</span>
              </div>
              <div class="text-caption">
                Creado el {{ solicitud.fecha_solicitud }}
              </div>
            </div>
            <div class="col-3 text-caption flex">
              <span
                class="q-my-auto seeMore"
                @click="
                  showedRequest = solicitud;
                  showRequestModal = true;
                "
                >Ver más >
              </span>
            </div>
          </q-card-section>
        </q-card>
      </div>
      <q-inner-loading :showing="userRequestsLoading">
        <q-spinner-gears size="50px" color="primary" />
      </q-inner-loading>
      <div class="flex flex-center">
        <q-pagination
          v-model="pagination.current"
          :max="pagination.max"
          :max-pages="5"
          direction-links
          @input="getPagination()"
          boundary-links
          icon-first="skip_previous"
          icon-last="skip_next"
          icon-prev="fast_rewind"
          icon-next="fast_forward"
        />
      </div>
    </div>
    <q-separator
      v-if="userRequests && userRequests.length > 0 && !edit"
      class="separator"
      spaced
    />
    <div id="form" class="formContainer q-mt-md">
      <h2 class="text-h5 no-margin q-pb-md">
        {{ edit ? "Editar" : "Nueva" }} solicitud
      </h2>
      <div
        class="full-width q-pa-md rounded-borders q-mb-md"
        style="background-color: #d1ecf1"
      >
        Para garantizar la evaluación de la solicitud debe enviarla con una
        semana de anticipación
      </div>
      <form action="" @submit.prevent="onSubmit" @reset="onReset">
        <div class="row">
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Tipo de sala: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-select
              v-model="form.tipo_formulario"
              dense
              outlined
              map-options
              emit-value
              :options="$tipo_salas"
              style="min-width: 150px"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Nombres y apellidos: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              :disable="disable"
              outlined
              dense
              v-model="form.nombre"
              type="text"
              placeholder="Nombres y apellidos"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Programa o dependencia: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-select
              outlined
              use-input
              @filter="programsFilter"
              dense
              :options="programas"
              v-model="form.programa_docente"
              :placeholder="
                form.programa_docente
                  ? ''
                  : 'Programa o dependencia del docente'
              "
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Documento de identidad: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              :disable="disable"
              outlined
              dense
              v-model="form.documento"
              type="text"
              placeholder="Número de identificación"
              bottom-slots
            >

            </q-input>
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Correo UTP: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              :disable="disable"
              outlined
              dense
              v-model="form.correo_utp"
              type="text"
              placeholder="Nombre de usuario del correo utp"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Correo alterno: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              outlined
              dense
              v-model="form.correo_alt"
              type="text"
              lazy-rules=""
              placeholder="Correo alterno"
              :rules="[
                (val) =>
                  $v.form.correo_alt.email || 'Debe ser un correo válido',
              ]"
            />
          </div>
          <div
            v-if="form.tipo_formulario === '0' || form.tipo_formulario === '2'"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Código asignatura: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '0' || form.tipo_formulario === '2'"
            class="col-12 col-sm-9 q-py-sm"
          >

            <q-input
              v-if="!disable_nombre_asignatura"
              v-model="form.codigo_asignatura"
              outlined
              placeholder="Código de la asignatura"
              dense
              lazy-rules
              :rules="[
                (val) =>
                  $v.form.codigo_asignatura.requiredIf ||
                  'Código asignatura requerido',
              ]"
            />
            <q-select
              v-if="disable_nombre_asignatura"
              outlined
              dense
              hide-selected
              use-input
              dropdown-icon=""
              input-debounce="0"
              fill-input
              map-options
              option-label="CODIGO"
              option-value="CODIGO"
              v-model="form.codigo_asignatura"
              :options="courses"
              @filter="searchCourse"
              @input="nombreAsignatura"
              @blur="courses = []"
              placeholder="Código de la asignatura"
              lazy-rules
              :rules="[
                (val) =>
                  $v.form.codigo_asignatura.requiredIf.uppercase ||
                  'Código asignatura requerido',
              ]"
            >
              <template v-slot:option="scope">
                <q-item v-bind="scope.itemProps" v-on="scope.itemEvents">
                  <q-item-section>
                    <q-item-label v-html="scope.opt.ASIGNATURA" />
                    <q-item-label caption>{{ scope.opt.CODIGO }}</q-item-label>
                  </q-item-section>
                </q-item>
              </template>
              <template v-slot:hint>
                El nombre de la asignatura se buscará automáticamente
              </template>
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Sin resultados
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm">
              Nombre
              {{ form.tipo_formulario === "1" ? "evento" : "asignatura" }}:
            </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              outlined
              :disable="
                disable_nombre_asignatura && form.tipo_formulario == '0'
              "
              dense
              v-model="form.nombre_asignatura"
              type="text"
              :placeholder="
                'Nombre ' +
                (form.tipo_formulario == '1' ? 'evento' : 'asignatura')
              "
              lazy-rules
              :rules="[
                (val) =>
                  $v.form.nombre_asignatura.required || 'Nombre requerido',
              ]"
            >
              <template v-slot:hint>
                <span
                  v-if="
                    form.tipo_formulario == '0' && disable_nombre_asignatura
                  "
                >
                  <span v-if="!form.codigo_asignatura" class="text-secondary" style="text-transform: uppercase">
                    Ingresa el código de la asignatura
                  </span>
                  <span v-else-if="courses.length == 0">
                    ¿Asignatura no coincide?
                    <span
                      class="manual_input"
                      @click.prevent="
                        disable_nombre_asignatura = false;
                        form.codigo_asignatura = null;
                      "
                      >click para ingreso manual</span
                    >
                  </span>
                </span>
              </template>
            </q-input>
          </div>
          <div
            v-if="form.tipo_formulario === '1'"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Sala: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '1'"
            class="col-12 col-sm-9 q-py-sm row"
          >
            <div class="col-4">
              <q-select
                v-model="videoconferencia_opt"
                :options="videoconferencia"
                label="Sala"
                dense
                outlined
                map-options
                emit-value
              />
            </div>
            <div
              v-if="videoconferencia_opt === 1"
              class="col-2 q-pl-md flex text-left"
            >
              <span class="text-bold textForm"> ¿Cuál?: </span>
            </div>
            <div v-if="videoconferencia_opt === 1" class="col-4">
              <q-input
                v-model="form.tipo_cubiculo"
                dense
                outlined
                map-options
                emit-value
              />
            </div>
          </div>
          <div
            v-if="form.tipo_formulario === '0' || form.tipo_formulario === '2'"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Grupo: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '0' || form.tipo_formulario === '2'"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-input
              outlined
              dense
              v-model="form.grupo"
              type="number"
              placeholder="Número del grupo"
              lazy-rules=""
              :rules="[(val) => $v.form.grupo.requiredIf || 'Grupo requerido']"
            />
          </div>
          <div
            v-if="form.tipo_formulario === '2'"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Tipo de cubículo: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '2'"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-select
              v-model="form.tipo_cubiculo"
              :options="cubiculos"
              dense
              outlined
              map-options
              option-value="id"
              option-label="nombre"
              emit-value
              label="Cubículo"
              lazy-rules=""
              :rules="[
                (val) =>
                  $v.form.tipo_cubiculo.requiredIf || 'Tipo cubículo requerido',
              ]"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Fecha inicio de solicitud: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              outlined
              dense
              v-model="form.fecha_solicitud_inicio"
              type="date"
              @input="compareDate()"
              placeholder="Fecha inicial de la solicitud"
              lazy-rules=""
              :rules="[
                (val) =>
                  $v.form.fecha_solicitud_inicio.required ||
                  'Fecha de inicio requerida',
              ]"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold textForm"> Fecha fin de solicitud: </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              outlined
              dense
              v-model="form.fecha_solicitud_fin"
              type="date"
              @input="compareDate()"
              placeholder="Fecha final de la solicitud"
              lazy-rules=""
              :rules="[
                (val) =>
                  $v.form.fecha_solicitud_fin.required ||
                  'Fecha de fin requerida',
                (val) =>
                  $v.form.fecha_solicitud_fin.greaterThan ||
                  'Fecha de fin debe ser mayor que fecha de inicio',
              ]"
            />
          </div>
          <div class="col-12 col-sm-3 flex text-left">
            <span class="text-bold q-mt-md"> Horario(s): </span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <div
              v-for="(horario, index) in form.Horarios"
              :key="index"
              class="relative-position"
            >
              <q-separator
                v-if="index > 0"
                class="full-width no-padding q-my-md"
              />
              <div class="scheduleGrid">
                <div class="flex no-wrap-sm day">
                  <span class="textForm scheduleText text-bold">Día:</span>
                  <q-select
                    v-model="horario.dia"
                    dense
                    :options="dias"
                    label="Día"
                    outlined
                    class="scheduleSelect"
                    map-options
                    emit-value
                    lazy-rules=""
                    :rules="[
                      (val) =>
                        $v.form.Horarios.$each[index].dia.required ||
                        'Día requerido',
                    ]"
                  />
                </div>
                <div class="flex no-wrap-sm time1">
                  <span class="textForm scheduleText text-bold">
                    Hora inicio:
                  </span>
                  <q-select
                    v-model="horario.hora_inicio"
                    dense
                    outlined
                    :options="horasF"
                    class="scheduleSelect"
                    label="Hora inicio"
                    map-options
                    emit-value
                    :rules="[
                      (val) =>
                        $v.form.Horarios.$each[index].hora_inicio.required ||
                        'Hora inicio requerida',
                      (val) =>
                        $v.form.Horarios.$each[index].hora_inicio.greaterThan ||
                        'Hora inicio debe ser menor que hora fin',
                    ]"
                  />
                </div>
                <div class="flex no-wrap-sm time2">
                  <span class="textForm scheduleText text-bold">
                    Hora fin:
                  </span>
                  <q-select
                    v-model="horario.hora_fin"
                    dense
                    outlined
                    :options="horas"
                    class="scheduleSelect"
                    label="Hora fin"
                    map-options
                    emit-value
                    :rules="[
                      (val) =>
                        (!$v.form.Horarios.$each[index].hora_fin.$dirty &&
                          $v.form.Horarios.$each[index].hora_fin.required) ||
                        'Hora fin requerida',
                      (val) =>
                        (!$v.form.Horarios.$each[index].hora_fin.$dirty &&
                          $v.form.Horarios.$each[index].hora_fin.greaterThan) ||
                        'Hora fin debe ser mayor que hora inicio',
                    ]"
                  />
                </div>
                <div
                  v-if="form.tipo_formulario === '2'"
                  class="flex no-wrap-sm"
                >
                  <span class="textForm scheduleText text-bold"
                    >Cubículo sugerido:</span
                  >
                  <q-select
                    v-model="horario.cubiculo"
                    :options="cubiculos_sugeridos"
                    menu-anchor="bottom left"
                    options-dense
                    :disable="!form.tipo_cubiculo"
                    map-options
                    class="scheduleSelect"
                    label="Cubículo sugerido"
                    option-label="nombre"
                    emit-value
                    option-value="nombre"
                    @filter="
                      (val, update, abort) => {
                        getSugested(val, update, abort);
                      }
                    "
                    dense
                    outlined
                  >
                    <template v-slot:no-option>
                      <q-item>
                        <q-item-section class="text-grey">
                          No se encontraron salas disponibles
                        </q-item-section>
                      </q-item>
                    </template>
                  </q-select>
                </div>
              </div>
              <div class="full-width text-center q-mt-md">
                <q-btn
                  v-if="index > 0"
                  no-caps
                  dense
                  class="q-px-sm"
                  color="red"
                  label="Eliminar horario"
                  @click="delSchedule(index)"
                />
              </div>
            </div>
            <q-separator class="full-width no-padding q-my-md" />
            <div class="flex flex-center q-mt-md">
              <q-btn
                color="primary"
                no-caps
                label="Agregar más Horarios"
                @click="addSchedule"
              />
            </div>
          </div>
          <div
            v-if="form.tipo_formulario !== 2"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm">
              Cantidad de
              {{ form.tipo_formulario !== "1" ? "estudiantes" : "asistentes" }}:
            </span>
          </div>
          <div
            v-if="form.tipo_formulario !== 2"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-input
              outlined
              dense
              v-model="form.cantidad_estudiantes"
              type="number"
              :placeholder="
                'Número de ' +
                (form.tipo_formulario === '0' ? 'estudiantes' : 'asistentes')
              "
            />
          </div>
          <div
            v-if="form.tipo_formulario === '0'"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Software necesario: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '0'"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-input
              outlined
              dense
              v-model="form.software_necesario"
              type="text"
              autogrow
              placeholder="Software que necesite"
            />
          </div>
          <div
            v-if="form.tipo_formulario === '0' && form.software_necesario"
            class="col-12 col-sm-3 flex text-left"
          >
            <span class="text-bold textForm"> Sistema operativo: </span>
          </div>
          <div
            v-if="form.tipo_formulario === '0' && form.software_necesario"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-select
              outlined
              dense
              :options="so"
              v-model="form.so"
              type="text"
              placeholder="Sistema operativo del software"
            />
          </div>
          <div
            v-if="form.tipo_formulario === '0' && form.software_necesario"
            class="col-12 col-sm-3 flex column text-left"
          >
            <span class="text-bold textForm"> Enlace de descarga: </span>
            <span class="text-grey text-caption">Opcional</span>
          </div>
          <div
            v-if="form.tipo_formulario === '0' && form.software_necesario"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-input
              outlined
              dense
              v-model="form.link"
              type="text"
              placeholder="Enlace de descarga del software"
            />
          </div>
          <div class="col-12 col-sm-3 column flex text-left">
            <span class="text-bold textForm"> Observaciones: </span>
            <span class="text-grey text-caption">Opcional</span>
          </div>
          <div class="col-12 col-sm-9 q-py-sm">
            <q-input
              outlined
              dense
              v-model="form.observaciones"
              type="text"
              autogrow
              placeholder="Observaciones"
            />
          </div>
          <div
            v-if="form.tipo_formulario === '0'"
            class="col-12 col-sm-3 column flex text-left"
          >
            <span class="text-bold textForm"> Equipos audiovisuales: </span>
            <span class="text-grey text-caption">Opcional</span>
          </div>
          <div
            v-if="form.tipo_formulario === '0'"
            class="col-12 col-sm-9 q-py-sm"
          >
            <q-checkbox
              color="primary"
              v-model="form.parlantes"
              label="Parlantes"
            />
            <q-checkbox
              color="primary"
              v-model="form.videobeam"
              label="Video proyector"
            />
            <q-checkbox
              color="primary"
              v-model="form.remota"
              label="Sistema para conexión remota"
            />
          </div>
          <div
            class="
              q-mt-lg
              formBtn
              col-12 col-sm-10
              offset-sm-1
              text-center
              q-gutter-x-md
            "
          >
            <span>
              <q-btn
                color="primary"
                label="Previsualizar solicitud"
                no-caps
                @click="
                  showedRequest = form;
                  showRequestModal = true;
                "
              />
            </span>
            <q-btn
              :disable="$v.form.$invalid"
              no-caps
              :loading="submitLoading"
              color="primary"
              :label="edit ? 'Actualizar' : 'Enviar'"
              type="submit"
            />
            <q-btn
              no-caps
              color="red"
              :label="edit ? 'Cancelar' : 'Reiniciar'"
              type="reset"
            />
          </div>
        </div>
      </form>
    </div>
    <q-dialog v-model="showRequestModal" persistent>
      <q-card v-if="showRequestModal" style="width: 1000px; max-width: 80vw">
        <q-card-section class="items-center">
          <div class="text-left q-pa-md row">
            <div class="user-info col-md-6 col-12">
              <div class="text-h6">Información de solicitud</div>
              <div>
                <b>Tipo de sala: </b>
                {{ $tipo_salasDic[showedRequest.tipo_formulario] }}
              </div>
              <div>
                <b>Programa o dependencia: </b
                >{{ showedRequest.programa_docente }}
              </div>
              <div><b>Correo Alterno: </b> {{ showedRequest.correo_alt }}</div>
              <div v-if="showedRequest.tipo_formulario !== '1'">
                <b>Código asignatura: </b>
                <span class="text-uppercase">{{
                  showedRequest.codigo_asignatura
                }}</span>
              </div>
              <div class="text-capitalize">
                <b
                  >Nombre
                  {{
                    showedRequest.tipo_formulario !== "1"
                      ? "asignatura"
                      : "evento"
                  }}:
                </b>
                {{ showedRequest.nombre_asignatura }}
              </div>
              <div v-if="showedRequest.tipo_formulario === '1'">
                <b>Sala: </b>
                {{
                  !showedRequest.tipo_cubiculo
                    ? "Asignado por el CRIE"
                    : showedRequest.tipo_cubiculo
                }}
              </div>
              <div v-if="showedRequest.tipo_formulario !== '1'">
                <b>Grupo: </b> {{ showedRequest.grupo }}
              </div>
              <div>
                <b>Fecha de inicio: </b>
                <span v-if="showedRequest.fecha_solicitud_inicio">{{
                  $dateFormat(showedRequest.fecha_solicitud_inicio)
                }}</span>
              </div>
              <div>
                <b>Fecha de fin: </b>
                <span v-if="showedRequest.fecha_solicitud_fin">{{
                  $dateFormat(showedRequest.fecha_solicitud_fin)
                }}</span>
              </div>
              <div>
                <b
                  >Cantidad de
                  {{
                    showedRequest.tipo_formulario !== "1"
                      ? "estudiantes"
                      : "asistentes"
                  }}:
                </b>
                {{ showedRequest.cantidad_estudiantes }}
              </div>
              <div v-if="showedRequest.tipo_formulario === '0'">
                <b>Software necesario: </b>
                {{ showedRequest.software_necesario }}
              </div>
              <div>
                <b>Observaciones: </b>
                {{ showedRequest.observaciones }}
              </div>
              <div v-if="showedRequest.tipo_formulario === '0'">
                <b>Equipos audiovisuales: </b>
                <div class="col-12 flex column col-sm-9 q-py-sm">
                  <q-checkbox
                    color="primary"
                    size="xs"
                    disable
                    v-model="showedRequest.parlantes"
                    label="Parlantes"
                  />
                  <q-checkbox
                    color="primary"
                    size="xs"
                    disable
                    v-model="showedRequest.videobeam"
                    label="Video proyector"
                  />
                  <q-checkbox
                    color="primary"
                    size="xs"
                    disable
                    v-model="showedRequest.remota"
                    label="Sistema para conexión remota"
                  />
                </div>
              </div>
            </div>

            <div class="user-info col-md-6 col-12">
              <div class="text-h6">Horarios</div>
              <q-table
                :data="showedRequest.Horarios"
                :columns="scheduleColumns"
                row-key="id"
                bordered
                flat
                hide-bottom
                class="schedule-list"
              >
                <template v-slot:header-cell-sala="props">
                  <q-th
                    v-if="showedRequest.estado === 'CONFIRMADO'"
                    :props="props"
                  >
                    {{
                      showedRequest.tipo_formulario === "0"
                        ? "Sala asignada"
                        : "Cubículo asignado"
                    }}
                  </q-th>
                </template>
                <template v-slot:body-cell-sala="props">
                  <q-td
                    v-if="showedRequest.estado === 'CONFIRMADO'"
                    :props="props"
                  >
                    {{ props.row.recurso_id }}
                  </q-td>
                </template>
                <template v-slot:header-cell-sugerido="">
                  <q-th v-if="showedRequest.tipo_formulario == '2'">
                    Cubiculo Sugerido
                  </q-th>
                </template>
                <template v-slot:body-cell-sugerido="props_c">
                  <q-td
                    v-if="showedRequest.tipo_formulario == '2'"
                    :props="props_c"
                  >
                    {{ props_c.row.cubiculo }}
                  </q-td>
                </template>
              </q-table>
            </div>
            <div class="text-center text-grey full-width text-caption">
              Si tiene dudas comunicarse al correo
              <a href="mailto:admsalas@utp.edu.co" target="_blank"
                >admsalas@utp.edu.co</a
              >
            </div>
          </div>
        </q-card-section>
        <q-card-actions align="right">
          <q-btn flat label="Cerrar" color="primary" v-close-popup />
          <q-btn
            v-if="!showedRequest.formulario_id"
            flat
            :disable="$v.form.$invalid"
            label="Enviar solicitud"
            @click="onSubmit()"
            color="primary"
            v-close-popup
          />
          <q-btn
            v-if="showedRequest.estado === 'PENDIENTE'"
            flat
            label="Editar"
            @click="onEdit()"
            color="primary"
            v-close-popup
          />
        </q-card-actions>
      </q-card>
    </q-dialog>
  </div>
</template>

<script>
import {
  required,
  email,
  numeric,
  minLength,
  requiredIf,
} from "vuelidate/lib/validators";

import { http } from "boot/axios";
import { date } from "quasar";

export default {
  name: "formRequest",
  data() {
    return {
      reset: true,
      disable: true,
      disable_nombre_asignatura: true,
      submitLoading: false,
      userRequestsLoading: false,
      showRequestModal: false,
      showedRequest: null,
      edit: false,
      courses: [],
      pagination: {
        current: 1,
        rowsPerPage: 3,
        max: 1,
      },
      filtro: {
        codigo_asignatura: null,
        fecha_solicitud_inicio: null,
        fecha_solicitud_fin: null,
        tipo_formulario: null,
      },
      estados_dic: {
        PENDIENTE: {
          label: "Pendiente",
          color: "red",
        },
        ASIGNADO: {
          label: "En proceso",
          color: "orange",
        },
        CONFIRMADO: {
          label: "Asignada",
          color: "green",
        },
        "SIN RECURSO DISPONIBLE": {
          label: "Sin recurso disponible",
          color: "yellow",
        },
      },
      form: {
        nombre: "",
        programa_docente: "",
        documento: "",
        correo_utp: "",
        correo_alt: "",
        codigo_asignatura: "",
        nombre_asignatura: "",
        grupo: "",
        tipo_cubiculo: null,
        fecha_solicitud_inicio: null,
        fecha_solicitud_fin: null,
        cantidad_estudiantes: null,
        software_necesario: null,
        parlantes: false,
        videobeam: false,
        remota: false,
        so: null,
        link: null,
        observaciones: "",
        tipo_formulario: "0",
        Horarios: [
          {
            dia: "",
            hora_inicio: "",
            hora_fin: "",
            cubiculo: null,
          },
        ],
      },
      horas: [
        { label: "6:00 am", value: "6:00" },
        { label: "6:30 am", value: "6:30" },
        { label: "7:00 am", value: "7:00" },
        { label: "7:30 am", value: "7:30" },
        { label: "8:00 am", value: "8:00" },
        { label: "8:30 am", value: "8:30" },
        { label: "9:00 am", value: "9:00" },
        { label: "9:30 am", value: "9:30" },
        { label: "10:00 am", value: "10:00" },
        { label: "10:30 am", value: "10:30" },
        { label: "11:00 am", value: "11:00" },
        { label: "11:30 am", value: "11:30" },
        { label: "12:00 pm", value: "12:00" },
        { label: "12:30 pm", value: "12:30" },
        { label: "1:00 pm", value: "13:00" },
        { label: "1:30 pm", value: "13:30" },
        { label: "2:00 pm", value: "14:00" },
        { label: "2:30 pm", value: "14:30" },
        { label: "3:00 pm", value: "15:00" },
        { label: "3:30 pm", value: "15:30" },
        { label: "4:00 pm", value: "16:00" },
        { label: "4:30 pm", value: "16:30" },
        { label: "5:00 pm", value: "17:00" },
        { label: "5:30 pm", value: "17:30" },
        { label: "6:00 pm", value: "18:00" },
        { label: "6:30 pm", value: "18:30" },
        { label: "7:00 pm", value: "19:00" },
        { label: "7:30 pm", value: "19:30" },
        { label: "8:00 pm", value: "20:00" },
        { label: "8:30 pm", value: "20:30" },
        { label: "9:00 pm", value: "21:00" },
        { label: "9:30 pm", value: "21:30" },
        { label: "10:00 pm", value: "22:00" },
      ],
      horasF: [],
      scheduleColumns: [
        {
          name: "dia",
          required: true,
          label: "Día",
          align: "left",
          field: (row) => this.$diasDic[row.dia],
          format: (val) => `${val}`,
        },
        {
          name: "hora_inicio",
          required: true,
          label: "Desde",
          align: "left",
          field: (row) => row.hora_inicio,
          format: (val) => `${val}`,
        },
        {
          name: "hora_fin",
          required: true,
          label: "Hasta",
          align: "left",
          field: (row) => row.hora_fin,
          format: (val) => `${val}`,
        },
        {
          name: "sugerido",
          required: true,
          align: "left",
        },
        {
          name: "sala",
          required: true,
          align: "left",
        },
      ],
      cubiculos: [],
      videoconferencia_opt: 0,
      videoconferencia: [
        {
          value: 0,
          label: "Asignado por el CRIE",
        },
        {
          value: 1,
          label: "Otro",
        },
      ],
      userRequests: null,
      formValidation: {},
      dias: this.$dias,
      cubiculos_sugeridos: null,
      so: ["Windows", "Linux", "MacOs"],
      programas: [],
      programasFilter: [],
    };
  },
  methods: {
    addSchedule() {
      this.form.Horarios.push({
        dia: null,
        hora_inicio: null,
        hora_fin: null,
        solicitud_id: null,
        cubiculo: null,
      });
    },
    delSchedule(index) {
      this.form.Horarios.splice(index, 1);
    },
    onSubmit() {
      if (this.$v.form.$invalid) return;
      this.submitLoading = true;
      if (!this.edit) {
        if (this.form.tipo_formulario === "0") {
          delete this.form.tipo_cubiculo;
          delete this.form.observaciones;
        }
        if (this.form.tipo_formulario !== "0") {
          delete this.form.software_necesario;
          delete this.form.videobeam;
          delete this.form.parlantes;
          delete this.form.remota;
          delete this.form.so;
          delete this.form.link;
        }
        // console.log("este es el form", this.form);
        http
          .post("create", this.form)
          .then(( data ) => {
            this.submitLoading = false;
            if (data.status === 200) {
              console.log("data", data);
              this.$q.notify({
                type: "success",
                message: "Solicitud creada",
              });
              this.onReset();
            }
          })
          .catch((err) => {
            this.submitLoading = false;
          });
        // }
      } else {
        delete this.form.rnum;
        this.form.formulario_id = parseInt(this.form.formulario_id);
        this.form.Horarios.forEach((item) => {
          item.formulario_id = parseInt(item.formulario_id);
          item.horario_id = parseInt(item.horario_id);
        });
        http
          .patch("update", this.form)
          .then(({ data }) => {
            if (data === 200) {
              this.$q.notify({
                type: "success",
                message: "Solicitud actualizada",
              });
              this.onReset();
            }
            this.submitLoading = false;
          })
          .catch((err) => {
            this.submitLoading = false;
          });
      }
    },
    onReset() {
      document.getElementById("form").scrollIntoView();
      this.edit = false;
      this.courses = [];
      this.form = {
        nombre: this.form.nombre,
        programa_docente: this.form.programa_docente,
        documento: this.form.documento,
        correo_utp: this.form.correo_utp,
        correo_alt: null,
        codigo_asignatura: null,
        nombre_asignatura: null,
        grupo: null,
        tipo_cubiculo: null,
        fecha_solicitud_inicio: null,
        fecha_solicitud_fin: null,
        cantidad_estudiantes: null,
        software_necesario: null,
        parlantes: true,
        videobeam: false,
        remota: false,
        so: null,
        link: null,
        observaciones: "",
        tipo_formulario: "0",
        Horarios: [
          {
            dia: "",
            hora_inicio: "",
            hora_fin: "",
            cubiculo: null,
          },
        ],
      };
      let THIS = this;
      this.reset = false;
      this.$nextTick(() => {
        THIS.$v.form.$reset();
        this.reset = true;
      });
      this.getUserRequests();
    },
    onResetFilter() {
      this.filtro = {
        codigo_asignatura: null,
        date: {
          from: new Date(),
          to: new Date(),
        },
        tipo_formulario: null,
      };
      this.getUserRequests();
    },
    onEdit() {
      this.edit = true;
      this.form = this.showedRequest;
      this.form.fecha_solicitud_inicio = this.$dateFormat(
        this.showedRequest.fecha_solicitud_inicio
      );
      this.form.fecha_solicitud_fin = this.$dateFormat(
        this.showedRequest.fecha_solicitud_fin
      );
      this.form.Horarios.forEach((item) => {
        delete item.horario_id;
        delete item.formulario_id;
      });
      setTimeout(() => {
        document.getElementById("form").scrollIntoView();
      }, 100);
    },
    getUserRequests() {
      this.userRequestsLoading = true;
      let filtro = { ...this.filtro };
      Object.keys(filtro).forEach((element) => {
        filtro[element] ? false : delete filtro[element];
        //console.log(filtro);
      });
      http
        .get("list", { params: filtro })
        .then(({ data }) => {
          this.userRequests = data.data;
          this.pagination.max = Math.ceil(
            parseInt(data.count) / this.pagination.rowsPerPage
          );
          this.userRequestsLoading = false;
        })
        .catch((err) => {
          this.userRequestsLoading = false;
        });
    },
    getPagination() {
      http.defaults.headers.common["limit"] = this.pagination.rowsPerPage;
      http.defaults.headers.common["page"] = this.pagination.current;
      this.getUserRequests();
      // console.log(this.pagination);
      // console.log(http.defaults.headers.common);
    },


    setUser() {
      document.getElementById("first").scrollIntoView();
      if (sessionStorage.getItem("user")) {
        let user = JSON.parse(sessionStorage.getItem("user"));
        this.form.nombre = user.nombres + " " + user.apellidos;
        this.form.documento = user.numerodocumento;
        this.form.correo_utp = user.correo;
      }
    },
    getCubicles() {
      http
        .get("tipocubiculos")
        .then(({ data }) => {
          this.cubiculos = data;
        })
        .catch((err) => {});
    },
    getSugested(val, update, abort) {
      http
        .get("listacubiculos", { params: { tipo_id: this.form.tipo_cubiculo } })
        .then(({ data }) => {
          this.cubiculos_sugeridos = data;
          update();
        })
        .catch((err) => {});
    },
    getPrograms() {
      http
        .get("listaprogramas")
        .then(({ data }) => {
          this.programas = data;
          this.programasFilter = data;
        })
        .catch((err) => {});
    },

    // getRecursos() {
    //   http
    //     .get("listarecursos")
    //     .then(({ data }) => {
    //       this.programas = data;
    //       this.programasFilter = data;
    //     })
    //     .catch((err) => {});
    // },

    programsFilter(val, update, abort) {
      update(() => {
        const needle = val
          .toLowerCase()
          .normalize("NFD")
          .replace(/[\u0300-\u036f]/g, "");
        this.programas = this.programasFilter.filter(
          (v) =>
            v
              .normalize("NFD")
              .replace(/[\u0300-\u036f]/g, "")
              .toLowerCase()
              .indexOf(needle) > -1
        );
      });
    },
    searchCourse(val, update, abort) {
      if (val.length < 2) {
        abort();
        return;
      } else {
        let codigoUpper = val.toUpperCase();
        http
          .get("listaasignaturas", {
            params: {
              codigo: codigoUpper,
            },
          })
          .then(({ data }) => {
            this.courses = data;

            if (this.courses.length == 1) {
              this.form.nombre_asignatura = this.courses[0].ASIGNATURA;
            }
            update();
          })
          .catch((err) => {});
      }
    },

    nombreAsignatura(val) {
      this.form.codigo_asignatura = val.CODIGO;
      this.form.nombre_asignatura = val.ASIGNATURA;
    },


    compareDate() {
      if (this.form.fecha_solicitud_inicio == this.form.fecha_solicitud_fin) {
        let day = date.formatDate(
          new Date(this.form.fecha_solicitud_inicio.replace(/-/g, "/")),
          "dddd"
        );
        this.dias = this.$dias.filter((item) => item.label == day);
        this.form.Horarios = [
          {
            dia: "",
            hora_inicio: "",
            hora_fin: "",
            cubiculo: null,
          },
        ];
      } else {
        this.dias = this.$dias;
      }
    },
    cerrarSesion() {
      sessionStorage.clear();
      this.$router.push("/login");
    },
  },
  validations: {
    form: {
      nombre: { required },
      programa_docente: { required },
      documento: { required, numeric },
      correo_utp: { required, email },
      correo_alt: { email },
      codigo_asignatura: {
        requiredIf: requiredIf(function () {
          return this.form.tipo_formulario !== "1";
        }),
      },
      nombre_asignatura: { required },
      grupo: {
        requiredIf: requiredIf(function () {
          return this.form.tipo_formulario !== "1";
        }),
      },
      tipo_cubiculo: {
        requiredIf: requiredIf(function () {
          return (
            this.form.tipo_formulario === "2" ||
            (this.form.tipo_formulario === "1" &&
              this.videoconferencia_opt === 1)
          );
        }),
      },
      fecha_solicitud_inicio: {
        required,
      },

      fecha_solicitud_fin: {
        required,
        greaterThan(val, { fecha_solicitud_inicio }) {
          if (!fecha_solicitud_inicio) return false;
          return (
            new Date(val.replace(/-/g, "/")) >=
            new Date(fecha_solicitud_inicio.replace(/-/g, "/"))
          );
        },
      },

      cantidad_estudiantes: { required },
      so: {
        requiredIf: requiredIf(function () {
          return (
            this.form.tipo_formulario === "0" && this.form.software_necesario
          );
        }),
      },
      Horarios: {
        required,
        minLength: minLength(1),
        $each: {
          dia: { required },
          hora_inicio: {
            required,
            greaterThan(val, { hora_fin }) {
              if (!hora_fin) return true;
              return (
                Date.parse("01/01/2011 " + val) <
                Date.parse("01/01/2011 " + hora_fin)
              );
            },
          },
          hora_fin: {
            required,
            greaterThan(val, { hora_inicio }) {
              if (!hora_inicio) return true;
              return (
                Date.parse("01/01/2011 " + val) >
                Date.parse("01/01/2011 " + hora_inicio)
              );
            },
          },
        },
      },
    },
  },
  mounted() {
    this.setUser();
    this.getCubicles();
    this.getPagination();
    this.getPrograms();
    // this.getRecursos();
    this.horasF = this.horas;
    this.horasF.pop();
  },
  watch: {
    showedRequest: function () {
      if (!this.showedRequest.parlantes || this.showedRequest.parlantes === "0")
        this.showedRequest.parlantes = false;
      else this.showedRequest.parlantes = true;
      if (!this.showedRequest.videobeam || this.showedRequest.videobeam === "0")
        this.showedRequest.videobeam = false;
      else this.showedRequest.videobeam = true;
      if (!this.showedRequest.remota || this.showedRequest.remota === "0")
        this.showedRequest.remota = false;
      else this.showedRequest.remota = true;
    },
  },
};
</script>

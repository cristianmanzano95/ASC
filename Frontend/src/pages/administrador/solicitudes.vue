<style lang="sass" scoped>
.info-row::before
  background: none

.user-info
  display: flex
  flex-direction: column
  gap: 10px
  div
    white-space: normal

.aditional-info
  transition: 3s
</style>
<template>
  <div class="container q-px-md">
    <h1 class="text-h5 full-width no-margin justify-start flex">
      Solicitudes
      {{
        currentRoute === 0
          ? "sin revisar"
          : currentRoute === 1
          ? "confirmadas"
          : currentRoute === 3
          ? "rechazadas"
          : "asignadas"
      }}
      <q-space />
      <q-file
        v-if="currentRoute === 0"
        dense
        label="Masiva cubículos"
        class="q-ml-auto q-mr-lg"
        accept=".csv"
        outlined
        v-model="csv_file_cubiculo"
        style="max-width: 200px"
      >
        <template v-slot:prepend>
          <q-icon name="attach_file" />
        </template>
        <template v-slot:append>
          <q-icon
            v-if="csv_file_cubiculo"
            name="close"
            @click.prevent="csv_file_cubiculo = null"
            class="cursor-pointer"
          />
        </template>
      </q-file>
      <q-file
        v-if="currentRoute === 0"
        dense
        label="Masiva cómputo"
        class="q-ml-auto q-mr-lg"
        accept=".csv"
        outlined
        v-model="csv_file_computo"
        style="max-width: 200px"
      >
        <template v-slot:prepend>
          <q-icon name="attach_file" />
        </template>
        <template v-slot:append>
          <q-icon
            v-if="csv_file_computo"
            name="close"
            @click.prevent="csv_file_computo = null"
            class="cursor-pointer"
          />
        </template>
      </q-file>
      <q-btn
        color="primary"
        outline
        v-if="csv_file_cubiculo || csv_file_computo"
        :disable="!csv_file_cubiculo && !csv_file_computo"
        no-caps
        label="Enviar"
        @click="uploadFile"
        :loading="loading_csv"
      />
    </h1>
    <h2 class="text-subtitle1 no-margin text-grey full-width">
      {{ totalRequests }}
      {{ totalRequests === 1 ? "Solicitud" : "Solicitudes" }}
    </h2>
    <div>
      <q-table
        :expanded="expanded"
        flat
        :data="data"
        :columns="columns"
        row-key="formulario_id"
        :pagination.sync="pagination"
        :loading="loading"
        @request="getPagination"
        binary-state-sort
      >
        <template v-slot:body="props">
          <q-tr
            class="cursor-pointer striped-row"
            @click="toggleExpanded(props)"
            :key="props.row.formulario_id"
            :props="props"
          >
            <q-td key="formulario_id" :props="props">
              {{ props.row.formulario_id }}
            </q-td>
            <q-td key="tipo_formulario" :props="props">
              {{ $tipo_salasDic[props.row.tipo_formulario] }}
            </q-td>
            <q-td key="nombre" :props="props">
              <span class="text-capitalize">
                {{ props.row.nombre }}
              </span>
            </q-td>
            <q-td key="nombre_asignatura" :props="props">
              <span class="text-capitalize">
                {{ props.row.nombre_asignatura }}
              </span>
            </q-td>
            <q-td key="fecha_solicitud" :props="props">
              {{ $dateFormatHour(props.row.fecha_solicitud) }}
            </q-td>
          </q-tr>
          <q-tr v-show="props.expand" :props="props">
            <q-td class="info-row" colspan="100%">
              <div class="text-left q-pa-md row">
                <div class="user-info col-md-4 col-12">
                  <div class="text-h6">Información del solicitante</div>
                  <div class="text-capitalize">
                    <b>Docente: </b> {{ props.row.nombre }}
                  </div>
                  <div class="text-capitalize">
                    <b>Solicitud desde: </b>
                    {{ $dateFormat(props.row.fecha_solicitud_inicio) }}
                  </div>
                  <div class="text-capitalize">
                    <b>Solicitud hasta: </b>
                    {{ $dateFormat(props.row.fecha_solicitud_fin) }}
                  </div>
                  <div class="text-capitalize">
                    <b>Programa Docente: </b> {{ props.row.programa_docente }}
                  </div>
                  <div>
                    <b>Documento de identidad: </b> {{ props.row.documento }}
                  </div>
                  <div><b>Correo UTP: </b> {{ props.row.correo_utp }}</div>
                  <div><b>Correo Alterno: </b> {{ props.row.correo_alt }}</div>
                  <div
                    v-if="
                      props.row.tipo_formulario == '2' ||
                      props.row.tipo_formulario == '0'
                    "
                  >
                    <b>Código asignatura: </b>
                    <span class="text-uppercase">{{
                      props.row.codigo_asignatura
                    }}</span>
                  </div>
                  <div class="text-capitalize">
                    <b
                      >{{
                        props.row.tipo_formulario != 1
                          ? "Asignatura:"
                          : "Evento:"
                      }}
                    </b>
                    {{ props.row.nombre_asignatura }}
                  </div>
                  <div
                    v-if="props.row.tipo_formulario == '2'"
                    class="text-capitalize"
                  >
                    <b>Tipo cubículo: </b> {{ props.row.tipo_cubiculo }}
                  </div>
                  <div><b>Grupo: </b> {{ props.row.grupo }}</div>
                  <div v-if="props.row.tipo_formulario === '0'">
                    <b>Software necesario: </b>
                    {{ props.row.software_necesario }}
                  </div>
                  <div v-if="props.row.tipo_formulario === '0' && props.row.so">
                    <b>Sistema operativo: </b>
                    {{ props.row.so }}
                  </div>
                  <div
                    v-if="props.row.tipo_formulario === '0' && props.row.link"
                  >
                    <b>Enlace: </b>
                    <span v-if="props.row.link.includes('https')">
                      <a :href="props.row.link" target="_blank">
                        {{ props.row.link }}
                      </a>
                    </span>
                    <span v-else>
                      {{ props.row.link }}
                    </span>
                  </div>
                  <div v-if="props.row.tipo_formulario === '0'">
                    <b>Equipos audiovisuales: </b>
                    <div class="col-12 flex column col-sm-9 q-py-sm">
                      <q-checkbox
                        true-value="1"
                        :false-value="null || '0'"
                        color="primary"
                        size="xs"
                        disable
                        v-model="props.row.parlantes"
                        label="Parlantes"
                      />
                      <q-checkbox
                        true-value="1"
                        false-value="0"
                        color="primary"
                        size="xs"
                        disable
                        v-model="props.row.videobeam"
                        label="Video proyector"
                      />
                      <q-checkbox
                        true-value="1"
                        false-value="0"
                        color="primary"
                        size="xs"
                        disable
                        v-model="props.row.remota"
                        label="Sistema para conexión remota"
                      />
                    </div>
                  </div>
                </div>

                <div class="user-info col-md-6 col-12">
                  <div class="text-h6">Información de horario</div>
                  <q-table
                    :data="props.row.Horarios"
                    :columns="scheduleColumns"
                    row-key="horario_id"
                    bordered
                    flat
                    hide-bottom
                    class="schedule-list"
                  >
                    <template v-slot:header-cell-sala="props">
                      <q-th v-if="currentRoute !== 3" :props="props">
                        {{
                          currentRoute === 0
                            ? "Asignar"
                            : currentRoute === 0
                            ? "Sala"
                            : "Sala asignada"
                        }}
                      </q-th>
                    </template>
                    <template v-slot:body-cell-sala="props_c">
                      <q-td
                        v-if="currentRoute !== 3"
                        :props="props_c"
                        style="min-width: 240px"
                      >
                        <div
                          v-if="
                            props.row.tipo_formulario != 1 ||
                            (props.row.tipo_formulario == 1 &&
                              !props.row.tipo_cubiculo)
                          "
                          class="flex"
                        >
                            <!-- v-model="props_c.row.recurso_id" -->
                          <q-select
                            v-model="props_c.row.recurso_id"
                            :value="props_c.row.recurso_nombre"
                            :options="rooms"
                            menu-anchor="bottom left"
                            :disable="props_c.row.empty"
                            options-dense
                            stack-label
                            @input="
                              currentRoute === 1
                                ? (props.row.cambio = '1')
                                : false
                            "
                            @filter="
                              (val, update, abort) => {
                                getRooms(val, update, abort, props_c.row);
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
                          <q-checkbox
                            v-if="currentRoute === 0 || currentRoute === 2"
                            class="q-pl-md"
                            left-label
                            :false-value="null"
                            dense
                            @input="props_c.row.recurso_id = null"
                            size="xs"
                            label="No asignar"
                            v-model="props_c.row.empty"
                          />
                        </div>
                        <div class="text-left" v-else>
                          {{ props.row.tipo_cubiculo }}
                        </div>
                      </q-td>
                    </template>
                    <template v-slot:header-cell-sugerido="">
                      <q-th v-if="props.row.tipo_formulario == '2'">
                        Sugerido
                      </q-th>
                    </template>
                    <template v-slot:body-cell-sugerido="props_c">
                      <q-td
                        v-if="props.row.tipo_formulario == '2'"
                        :props="props_c"
                      >
                        {{ props_c.row.recurso_nombre }}
                      </q-td>
                    </template>
                  </q-table>
                </div>
                <div
                  class="
                    col-md-2 col-12
                    flex
                    items-start
                    q-pt-xl
                    justify-center
                  "
                >
                  <q-btn
                    v-if="currentRoute === 0"
                    no-caps
                    color="primary"
                    :loading="loadingAsignBtn"
                    label="Asignar
                    "
                    @click="asignRequest(props.row)"
                    :disable="
                      props.row.Horarios.some(
                        (i) => !i.recurso_id && !i.empty
                      ) &&
                      props.row.tipo_formulario != 1 &&
                      !props.row.tipo_cubiculo
                    "
                  />
                  <div class="flex column">
                    <q-btn
                      v-if="currentRoute === 1 && props.row.cambio == 1"
                      no-caps
                      color="primary"
                      :loading="loadingAsignBtn"
                      label="Notificar cambios"
                      @click="asignRequest(props.row)"
                    />
                    <q-btn
                      class="q-mt-sm"
                      v-if="currentRoute === 2"
                      no-caps
                      color="primary"
                      :label="
                        props.row.cambio == 1
                          ? 'Notificar cambios'
                          : 'Confirmar solicitud'
                      "
                      :disable="
                        props.row.Horarios.some(
                          (i) => !i.recurso_id && !i.empty
                        ) &&
                        props.row.tipo_formulario != 1 &&
                        !props.row.tipo_cubiculo
                      "
                      :loading="loadingConfirm"
                      @click="confirmRequest(props.row)"
                    />
                    <q-btn
                      class="q-mt-sm"
                      v-if="currentRoute !== 0 && currentRoute !== 3"
                      no-caps
                      color="warning"
                      label="Volver a pendiente"
                      :loading="loadingEditBtn"
                      @click="editAsigned(props.row.formulario_id, 'PENDIENTE')"
                    />
                  </div>
                </div>
              </div>
            </q-td>
          </q-tr>
        </template>
      </q-table>
    </div>
  </div>
</template>

<script>
import { httpAdmin } from "boot/axios";
export default {
  name: "solicitudes",
  props: ["filtro"],
  data() {
    return {
      loading: false,
      loadingAsignBtn: false,
      loadingConfirm: false,
      loadingEditBtn: false,
      totalRequests: 0,
      currentRoute: null,
      nameRoom:"",
      routeMap: {
        pendientes: 0,
        confirmadas: 1,
        asignadas: 2,
        rechazadas: 3,
      },
      selectedRoom: null,
      expanded: [],
      columns: [
        {
          name: "formulario_id",
          required: true,
          label: "Id",
          align: "left",
          sortable: true,
        },
        {
          name: "tipo_formulario",
          required: true,
          label: "Tipo solicitud",
          align: "left",
          sortable: true,
        },
        {
          name: "nombre",
          required: true,
          label: "Nombre y apellido",
          align: "left",
          field: (row) => row.nombre,
          format: (val) => `${val}`,
          sortable: true,
        },
        {
          name: "nombre_asignatura",
          required: true,
          label: "Asignatura",
          align: "left",
          sortable: true,
        },
        {
          name: "fecha_solicitud",
          required: true,
          label: "Fecha de solicitud",
          align: "left",
          sortable: true,
        },
      ],
      scheduleColumns: [
        {
          name: "dia",
          required: true,
          label: "Día",
          align: "left",
          field: (row) => row.dia,
          format: (val) => this.$diasDic[val],
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
      data: [],
      requests: [],
      pagination: {
        page: 1,
        rowsPerPage: 10,
        rowsNumber: 0,
        sortBy: "fecha_solicitud",
        descending: false,
      },
      rooms: [],
      csv_file_cubiculo: null,
      csv_file_computo: null,
      loading_csv: false,
    };
  },
  mounted() {
    this.getPagination();
    this.$events.$on("filter", () => {
      this.filter();
    });
  },
  created() {
    this.currentRoute = this.routeMap[this.$route.name];
  },
  methods: {

    toggleExpanded(val) {
      this.expanded =
        this.expanded[0] === val.row.formulario_id
          ? []
          : [val.row.formulario_id];
      this.data = JSON.parse(JSON.stringify(this.requests));

console.log(val);
    },
    /**
     *
     */


    getPagination(props) {
      props ? (this.pagination = props.pagination) : false;
      httpAdmin.defaults.headers.common["order"] = this.pagination.sortBy;
      httpAdmin.defaults.headers.common["order_type"] = this.pagination
        .descending
        ? "desc"
        : "asc";
      httpAdmin.defaults.headers.common["limit"] = this.pagination.rowsPerPage;
      httpAdmin.defaults.headers.common["page"] = this.pagination.page;
      this.getRequests();
    },
    getRequests() {
      this.loading = true;
      let filtro = { ...this.filtro };
      Object.keys(filtro).forEach((element) => {
        filtro[element] ? false : delete filtro[element];
      });
      //console.log("Aca se hace un filtro", filtro);
       httpAdmin
        .get("/" + this.$route.name, { params: filtro })
        .then(({ data }) => {
          this.data = data.data;
          this.requests = JSON.parse(JSON.stringify(data.data));
          if (this.currentRoute === 2)
            this.requests.forEach((request) => {
              request.Horarios.forEach((schedule) => {
                if (!schedule.recurso_id) {
                  schedule.empty = true;
                }
              });
            });
          this.pagination.rowsNumber = parseInt(data.count);
          this.totalRequests = parseInt(data.count);
          this.loading = false;
        })
        .catch((err) => {
          this.loading = false;
        });
    },
    getRooms(val, update, abort, row) {
      console.log("Aquí va un row");
      console.log(row);
      console.log("Aquí va un val");
      console.log(val);
      console.log("Aquí va un update");
      console.log(update);
      console.log("Aquí va un abort");
      console.log(abort);
      httpAdmin
        .get("rooms", {
          params: {
            formulario_id: row.formulario_id,
            horario_id: row.horario_id,
          },
        })
        .then(({ data }) => {
          this.rooms = data;
          update();
        console.log("rooms-DATA",data);
        })
        .catch((err) => {});
    },
    confirmRequest(item) {
      this.loadingConfirm = true;
      let body = {};
      body.formulario_id = item.formulario_id;
      body.Horarios = [];
      item.Horarios.forEach((element) => {
        let obj = {
          horario_id: element.horario_id,
          recurso_id: element.recurso_id,
        };
        body.Horarios.push(obj);
      });
//Esta asignar se activa en la vista de solicitudes en proceso, al confirmar la solicitud
      httpAdmin
        .post("asignar", body)
        .then(({ data }) => {

          if (data === 200)

            httpAdmin
              .post("confirmar", body)
              .then(({ data }) => {
                if (data === 200) this.getPagination();
                this.loadingConfirm = false;
              })


              .catch((err) => {
                this.loadingConfirm = false;
              });
        })
        .catch((err) => {
          this.loadingConfirm = false;
        });
    },
    asignRequest(item) {
      this.loadingAsignBtn = true;
      let body = {
        formulario_id: item.formulario_id,
        Horarios: [],
      };
      item.Horarios.forEach((element) => {
        let obj = {
          horario_id: element.horario_id,
          recurso_id: element.recurso_id,
        };
        body.Horarios.push(obj);
      });
      httpAdmin
        .post("asignar", body)
        .then(({ data }) => {
          if (data === 200) this.getPagination();
          this.loadingAsignBtn = false;
        })
        .catch((err) => {
          this.loadingAsignBtn = false;
        });
    },
    editAsigned(value, estado) {
      this.loadingEditBtn = true;
      httpAdmin
        .patch("update", { formulario_id: value, estado: estado })
        .then(({ data }) => {
          this.getPagination();
          this.loadingEditBtn = false;
        })
        .catch((err) => {
          this.loadingEditBtn = false;
        });
    },
    filter() {
      this.getPagination();
    },
    uploadFile() {
      this.loading_csv = true;
      if (this.csv_file_cubiculo) {
        let formDataCu = new FormData();
        formDataCu.append("csv", this.csv_file_cubiculo);
        httpAdmin
          .post("/masivo_cubiculo", formDataCu)
          .then((data) => {
            this.csv_file_cubiculo = null;
            this.loading_csv = false;
            this.getPagination();
          })
          .catch((err) => {});
      }
      if (this.csv_file_computo) {
        let formDataCo = new FormData();
        formDataCo.append("csv", this.csv_file_computo);
        httpAdmin
          .post("/masivo_computo", formDataCo)
          .then((data) => {
            this.csv_file_computo = null;
            this.loading_csv = false;
            this.getPagination();
          })
          .catch((err) => {});
      }
    },
  },
  watch: {
    $route(to, from) {
      this.currentRoute = this.routeMap[to.name];
      this.data = [];
      this.totalRequests = 0;
      this.getPagination();
    },
  },
};
</script>

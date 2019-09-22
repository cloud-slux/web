<template>
  <div class="md-layout-item md-small-size-100">
    <md-field v-if="visible">
      <label :for="name">{{ label }}</label>
      <md-input v-model="inputDisplay" :name="name" :placeholder="placeholder" :disabled="disabled"></md-input>
      <md-button class="md-raised md-primary md-icon-button" @click.native="onPickerModalActive()">
        <md-icon>search</md-icon>
      </md-button>
    </md-field>

    <md-dialog :md-active.sync="pickerModalAtive">
      <md-dialog-title>Selecionador de Registros: {{ label }}</md-dialog-title>

      <md-app md-dynamic-width md-dynamic-height>
        <md-app-toolbar>
          <div class="md-layout md-gutter">
            <div class="md-layout-item">
              <md-field md-clearable class="md-toolbar-section-end">
                <label for="pickerFilter">Filtro</label>
                <md-input
                  v-model="pickerFilter"
                  name="pickerFilter"
                  placeholder="Digite aqui para filtrar..."
                  @input="debouncedUpdateFilter"
                ></md-input>
              </md-field>
            </div>
          </div>
        </md-app-toolbar>

        <md-app-content>
          <p>
            <md-table
              v-model="pickerSearched"
              md-sort="id"
              md-sort-order="asc"
              md-card
              md-fixed-header
              @md-selected="onSelect"
            >
              <md-table-toolbar>
                <div class="md-toolbar-section-start">
                  <md-progress-spinner md-mode="indeterminate" v-if="pickerLoading"></md-progress-spinner>
                  <!-- <h1 class="md-title">{{ label }}</h1> -->
                </div>

                <md-field md-clearable class="md-toolbar-section-end">
                  <md-input
                    placeholder="Pesquisar..."
                    v-model="pickerSearch"
                    @input="debouncedUpdateSearch"
                  />
                </md-field>
              </md-table-toolbar>

              <md-table-empty-state
                md-label="Nenhum Registro Encontrado"
                md-description="Tente outros termos de filtro ou pesquisa."
              ></md-table-empty-state>

              <md-table-row slot="md-table-row" slot-scope="{ item }" md-selectable="single">
                <md-table-cell
                  v-for="pickerSchemaField in pickerDeclaredVisibleSchema"
                  :md-label="pickerSchemaField.shortAlias"
                  :md-sort-by="pickerSchemaField.name"
                  :key="pickerSchemaField.name"
                >{{ item[pickerSchemaField.name] }}</md-table-cell>

                <!-- <md-table-cell md-label="Código" md-sort-by="name">{{ item.code }}</md-table-cell>
                <md-table-cell md-label="Descrição" md-sort-by="valor">{{ item.description }}</md-table-cell>-->
              </md-table-row>
            </md-table>
          </p>
        </md-app-content>
      </md-app>

      <md-dialog-actions>
        <md-button class="md-accent" @click="onPickerModalCancel()">Cancelar</md-button>
        <md-button class="md-primary" @click="onPickerModalConfirm()">Selecionar</md-button>
      </md-dialog-actions>
    </md-dialog>

    <md-dialog-alert
      :md-active.sync="noPickedAlert"
      md-content="Selecione ao menos um registro"
      md-confirm-text="Entendido"
    />
  </div>
</template>
<script>
import { mapState, mapGetters } from "vuex";

import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

const toLower = text => {
  return text.toString().toLowerCase();
};

const searchByName = (items, term) => {
  if (term) {
    return items.filter(item =>
      toLower(item.description).includes(toLower(term))
    );
  }

  return items;
};

export default {
  name: "pickerInput",
  props: [
    "placeholder",
    "label",
    "name",
    "value",
    "mode",
    "pickerRoute",
    "pickerSchema",
    "pickerHiddenFields",
    "pickerHooks",
    "pickerPreFilter",
    "pickerDisplayExpression"
  ],
  data() {
    return {
      inputValue: this.value,
      inputDisplay: this.value,
      pickerModalAtive: false,
      noPickedAlert: false,
      pickerData: [],
      pickerSearched: [],
      pickerDeclaredRoute: this.pickerRoute,
      pickerDeclaredSchema: this.pickerSchema,
      pickerDeclaredHiddenFields: this.pickerHiddenFields,
      pickerDeclaredHooks: this.pickerHooks,
      pickerFilter: "",
      pickerSearch: "",
      pickerLoading: false,
      picked: {}
    };
  },
  computed: {
    ...mapState(fullModuleName, {
      visible(state) {
        return state.fields[this.name].visible;
      }
    }),
    ...mapGetters(fullModuleName, {
      apiUrl: "getApiUrl",
      visibilityTriggers: "getVisibilityTriggers",
      fields: "getFields"
    }),
    disabled() {
      return this.name === "_id";
    },
    pickerDeclaredVisibleSchema() {
      const pickerDeclaredVisibleSchema = Object.assign(
        {},
        this.pickerDeclaredSchema
      );
      this.pickerDeclaredHiddenFields.forEach(hiddenField => {
        delete pickerDeclaredVisibleSchema[hiddenField];
      });
      return pickerDeclaredVisibleSchema;
    }
  },
  created: function() {
    this.debouncedUpdateSearch = _.debounce(this.searchOnTable, 250);
    this.debouncedUpdateFilter = _.debounce(this.filterOnTable, 250);
    this.pickerSearched = this.pickerData;
  },
  methods: {
    onPickerModalActive() {
      this.pickerFilter = "";
      this.pickerSearch = "";
      this.picked = {};
      this.pickerModalAtive = true;
      this.filterOnTable();
    },
    onPickerModalConfirm() {
      if (Object.keys(this.picked).length === 0) {
        this.noPickedAlert = true;
      } else {
        this.inputValue = this.picked._id;
        this.inputDisplay = eval(`\`${this.pickerDisplayExpression}\``);

        this.$store.dispatch(fullModuleName + "/changeDataProperty", {
          property: this.name,
          value: this.inputValue
        });

        this.pickerDeclaredHooks.forEach(element => {
          this.$store.dispatch(fullModuleName + "/changeDataProperty", {
            property: element["property"],
            value: eval(`\`${element["value"]}\``)
          });
        });

        this.pickerModalAtive = false;
      }
    },
    onPickerModalCancel() {
      this.pickerModalAtive = false;
    },
    onSelect(item) {
      this.picked = item;
    },
    searchOnTable() {
      this.pickerSearched = searchByName(this.pickerData, this.pickerSearch);
    },
    filterOnTable() {
      let limit = 5;
      if (!!this.pickerFilter) {
        limit = 999;
      }

      let fullurl = `${this.apiUrl}${this.pickerDeclaredRoute}?limit=${limit}&select=`;

      let preFilterSentence = "";
      if (this.pickerPreFilter.length > 0) {
        preFilterSentence = `.AND.${this.pickerPreFilter}`;
      }

      let schemaNames = Object.keys(this.pickerDeclaredSchema);
      let schemaFilters = [...schemaNames.keys()];
      for (let index = 0; index < schemaNames.length; index++) {
        schemaFilters[
          index
        ] = `'${schemaNames[index]}'$cts"${this.pickerFilter}"`;
      }

      fullurl += schemaNames.join(",");
      if (!(this.pickerFilter === "")) {
        fullurl += `&q=(${schemaFilters.join(".OR.")})${preFilterSentence}`;
      }
      //this.pickerLoading = true;
      axios.get(fullurl, { crossdomain: true }).then(response => {
        //this.pickerLoading = false;
        this.pickerData = response.data.data;
        this.pickerSearched = this.pickerData;
      });
    }
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {
      if (mutation.type === fullModuleName + "/API_CALL") {
        if (this.mode === "create") {
          this.inputValue = "";
        }
      }
    });

    this.$store.subscribe((mutation, state) => {
      if (mutation.type === fullModuleName + "/CHANGE_DATA_PROPERTY") {
        const { property, value } = mutation.payload;
        if (this.visibilityTriggers.hasOwnProperty(property)) {
          const behaviors = this.visibilityTriggers[property];
          behaviors["behaviors"].forEach(behavior => {
            if (behavior.value == value) {
              for (var field in this.fields) {
                if (this.fields.hasOwnProperty(field)) {
                  this.fields[
                    field
                  ].visible = !behavior.invisibleFields.includes(field);
                }
              }
            }
          });
        }
      }
    });
  }
};
</script>

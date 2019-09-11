<template>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">
      <div class="md-layout md-gutter">
        <div class="md-layout-item">
          <md-field>
            <label for="fieldInput">Campos</label>
            <md-select
              v-model="fieldInput"
              name="fields"
              id="fields"
              :disabled="operatorType==='connector'"
            >
              <md-option
                v-for="field in fields"
                :key="field.name"
                v-bind:value="field.name"
              >{{ field.alias }}</md-option>
            </md-select>
          </md-field>
        </div>

        <div class="md-layout-item">
          <md-field>
            <label for="operatorInput">Operador</label>
            <md-select v-model="operatorInput" name="operators" id="operators">
              <md-option
                v-for="operator in operators"
                :key="operator.value"
                v-bind:value="operator.value"
              >{{ operator.display }}</md-option>
            </md-select>
          </md-field>
        </div>

        <div class="md-layout-item" v-if="['single', 'double', 'array'].includes(operatorType)">
          <md-field v-if="UIComponent==='input'">
            <label>Valor de Filtro</label>
            <md-input v-model="valueInput" :type="inputType"></md-input>
          </md-field>

          <md-datepicker v-model="dateInput" v-if="UIComponent==='datepicker'" md-immediately />
        </div>

        <div class="md-layout-item" v-if="operatorType==='double'">
          <md-field v-if="UIComponent==='input'">
            <label>Valor de Filtro Final</label>
            <md-input v-model="valueInput2" :type="inputType"></md-input>
          </md-field>

          <md-datepicker v-model="dateInput2" v-if="UIComponent==='datepicker'" md-immediately />
        </div>

        <div class="md-layout-item" v-if="operatorType==='array'">
          <div class="md-layout-item">
            <md-button @click="addValueHit()">Adicionar Valor</md-button>
          </div>
        </div>

        <div class="md-layout-item" v-if="operatorType==='array'">
          <li class="list-group-item">
            <div>
              <md-chips class="md-primary shake-on-error" v-model="values" md-check-duplicated>
                <template slot="md-chip" slot-scope="{ chip }">
                  <strong>{{ chip }}</strong>
                </template>
              </md-chips>
            </div>
          </li>
        </div>

        <div class="md-layout-item" v-if="operatorType==='connector'">
          <md-field>
            <label for="connectorInput">Conectores</label>
            <md-select v-model="connectorInput" name="connectors" id="connectors">
              <md-option
                v-for="connector in connectors"
                :key="connector.value"
                v-bind:value="connector.value"
              >{{ connector.display }}</md-option>
            </md-select>
          </md-field>
        </div>

        <div class="md-layout-item">
          <md-button class="md-raised" @click="addFilterHit()">Adicionar Filtro</md-button>
        </div>
      </div>
    </li>

    <li class="list-group-item">
      <div>
        <md-chips
          class="md-primary shake-on-error"
          v-model="filters"
          :md-format="isErpFilterFormat"
          md-check-duplicated
        >
          <template slot="md-chip" slot-scope="{ chip }">
            <!-- {{ formatChip(chip) }} -->
            <strong>
              <small>{{ fieldFromFilter(chip) }}</small>
            </strong>
            <small>{{ operatorFromFilter(chip) }}</small>
            <strong>{{ valueFromFilter(chip) }}</strong>
          </template>
          <div class="md-helper-text">Filtro no formato: campo + operador($equals) + filtro</div>
        </md-chips>
      </div>
    </li>

    <li class="list-group-item">
      <div class="md-layout md-gutter">
        <div class="md-layout-item">
          <md-field>
            <label for="limitInput">Linhas Por Página</label>
            <md-select v-model="limitInput" name="limits" id="limits">
              <md-option v-for="limit in limitOptions" :key="limit" v-bind:value="limit">{{ limit }}</md-option>
            </md-select>
          </md-field>
        </div>

        <div class="md-layout-item">
          <md-button class="md-primary md-raised" @click="refreshHit()">Atualizar Informações</md-button>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
import { mapState, mapActions } from "vuex";
import { moduleName } from "../../helpers/dynamicModule";

export default {
  name: "filterBox",
  data: () => ({
    filters: [],
    limitOptions: [5, 10, 20, 50],
    limitInput: 5,
    fieldInput: "_id",
    operators: [
      { display: "Contém", value: "$cts", type: "single" },
      { display: "Igual", value: "$eq", type: "single" },
      { display: "Lógico", value: "$logical", type: "connector" },
      { display: "Entre", value: "$btw", type: "double" },
      { display: "Está Contido Em", value: "$in", type: "array" },
      { display: "Não Está Contido Em", value: "$nin", type: "array" },
      { display: "Maior Que", value: "$gt", type: "single" },
      { display: "Menor Que", value: "$lt", type: "single" },
      { display: "Maior Ou Igual Que", value: "$gte", type: "single" },
      { display: "Menor Ou Igual Que", value: "$lte", type: "single" }
    ],
    operatorInput: "$cts",
    operatorType: "single",
    valueInput: "",
    valueInput2: "",
    dateInput: new Date(),
    dateInput2: new Date(),
    connectorInput: "(",
    values: [],
    connectors: [
      { display: "(", value: "(" },
      { display: ")", value: ")" },
      { display: "E", value: ".AND." },
      { display: "OU", value: ".OR." },
      { display: "NEM", value: ".NOR." }
    ],
    UIComponent: "input",
    inputType: "text"
  }),
  computed: {
    ...mapState(moduleName(), {
      loading: state => state.loading,
      page: state => state.page,
      limit: state => state.limit,
      response: state => state.response,
      fields: state => state.fields
    })
  },
  mounted() {
    this.$material.locale.dateFormat = "dd/MM/yyyy";
  },
  watch: {
    operatorInput(val) {
      const matchedOperator = this.operators.find(
        operator => operator.value == val
      );
      //console.log(val, operator, operator.display, operator.type, operator.value);
      this.operatorType = matchedOperator.type;
    },
    fieldInput(val) {
      const matchedField = this.fields[val];
      console.log("val", val, "mat", matchedField);
      if (["text", "number"].includes(matchedField.type)) {
        this.UIComponent = "input";
        this.inputType = matchedField.type;
      } else if (["datepicker"].includes(matchedField.type)) {
        this.UIComponent = "datepicker";
      } else {
        console.log(
          "Tipo de Campo ",
          matchedField.type,
          " Inexistente para o campo",
          matchedField.name
        );
      }

      this.inputType = matchedField.type;
    }
  },
  methods: {
    isErpFilterFormat(str) {
      str = str.replace(/\s/g, "");

      if (this.connectors.map(connector => connector.display).includes(str)) {
        return str;
      }

      const ops = this.operators.map(operator => operator.value);

      let retorno = false;

      ops.forEach(operator => {
        if (str.includes(operator)) {
          const field = str.substring(0, str.indexOf(operator));
          const filter = str
            .substring(str.indexOf(operator))
            .replace(operator, "");

          if (
            field !== null &&
            field.replace(/\s/g, "").length >= 1 &&
            filter !== null &&
            filter.replace(/\s/g, "").length >= 1
          ) {
            retorno = str;
          }
        }
      });

      return retorno;
    },
    fieldFromFilter(filter) {
      if (this.connectors.map(connector => connector.value).includes(filter)) {
        return "";
      } else {
        let foundFieldString = "";
        this.operators.forEach(operator => {
          if (filter.includes(operator.value)) {
            const field = filter.substring(0, filter.indexOf(operator.value));
            var re = new RegExp("'", "g");
            foundFieldString = field.replace(re, "");
          }
        });

        let foundFieldObject;
        for (var property in this.fields) {
          if (this.fields.hasOwnProperty(property)) {
            const field = this.fields[property];
            if (field.name == foundFieldString) {
              foundFieldObject = field;
            }
          }
        }

        let retorno = "";
        retorno = foundFieldObject.alias;

        return retorno;
      }
    },
    operatorFromFilter(filter) {
      if (this.connectors.map(connector => connector.value).includes(filter)) {
        return "";
      } else {
        let retorno = "";

        this.operators.forEach(operator => {
          if (filter.includes(operator.value)) {
            retorno = operator.display;
          }
        });
        return retorno;
      }
    },
    valueFromFilter(filter) {
      const cons = this.connectors.map(connector => connector.value);
      if (cons.includes(filter)) {
        const conn = this.connectors.find(
          connector => connector.value === filter
        );
        return conn.display;
      } else {
        let retorno = "";

        this.operators.forEach(operator => {
          if (filter.includes(operator.value)) {
            const value = filter
              .substring(filter.indexOf(operator.value))
              .replace(operator.value, "");
            retorno = value;
          }
        });

        return retorno;
      }
    },
    addValueHit() {
      switch (this.UIComponent) {
        case "input":
          switch (this.inputType) {
            case "text":
              this.values.push(`"${this.valueInput}"`);
              break;
            case "number":
              this.values.push(`${this.valueInput}`);
              break;
            default:
              console.log(this.inputType, " não mapeado");
          }
          break;
        case "datepicker":
          this.values.push(`"${this.dateInput.toLocaleDateString("pt-BR")}"`);
          break;
        default:
          console.log(this.UIComponent, " não mapeado");
      }
    },
    addFilterHit() {
      if (this.operatorType === "connector") {
        this.filters.push(this.connectorInput);
        return;
      } else {
        let filter = `'${this.fieldInput}'${this.operatorInput}`;

        switch (this.operatorType) {
          case "single":
            switch (this.UIComponent) {
              case "input":
                switch (this.inputType) {
                  case "text":
                    filter += `"${this.valueInput}"`;
                    break;
                  case "number":
                    filter += `${this.valueInput}`;
                    break;
                  default:
                    console.log(this.inputType, " não mapeado");
                }
                break;
              case "datepicker":
                filter += `"${this.dateInput.toLocaleDateString("pt-BR")}"`;
                break;
              default:
                console.log(this.UIComponent, " não mapeado");
            }
            break;
          case "double":
            switch (this.UIComponent) {
              case "input":
                switch (this.inputType) {
                  case "text":
                    filter += `"${this.valueInput}":"${this.valueInput2}"`;
                    break;
                  case "number":
                    filter += `${this.valueInput}:${this.valueInput2}`;
                    break;
                  default:
                    console.log(this.inputType, " não mapeado");
                }
                break;
              case "datepicker":
                filter += `"${this.dateInput.toLocaleDateString(
                  "pt-BR"
                )}":"${this.dateInput2.toLocaleDateString("pt-BR")}"`;
                break;
              default:
                console.log(this.UIComponent, " não mapeado");
            }
            break;
          case "array":
             filter += `[${this.values.join(',')}]`;
          default:
            console.log(this.operatorType, " não mapeado");
        }

        if (!this.filters.includes(filter)) {
          this.filters.push(filter);
        } else {
          let foundFieldObject;
          // this.fields.forEach(field => {
          //   if (field.name == fieldInput) {
          //     foundFieldObject = field;
          //   }
          // });

          for (var property in this.fields) {
            if (this.fields.hasOwnProperty(property)) {
              const field = this.fields[property];
              if (field.name == fieldInput) {
                foundFieldObject = field;
              }
            }
          }

          let retorno = "";
          retorno = foundFieldObject.alias;

          const msg = ` O campo ${retorno} já tem filtro para este valor: ${valueInput}`;
          this.$bvToast.toast(msg, {
            title: "Aviso de Duplicidade",
            toaster: "b-toaster-top-center",
            autoHideDelay: 2000,
            variant: "warning"
          });
        }
      }
    },
    refreshHit() {
      const queryFilter = this.filters.join("");

      this.$store.dispatch(moduleName() + "/changeQueryFilter", queryFilter);
      this.$store.dispatch(moduleName() + "/changeToolFilter", "");
      this.$store.dispatch(moduleName() + "/changePage", Number(1));
      this.$store.dispatch(
        moduleName() + "/changeLimit",
        Number(this.limitInput)
      );
      this.$store.dispatch(moduleName() + "/apiFetch", this.page);
    }
  }
};
</script>


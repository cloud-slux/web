<template>
  <div class="md-layout-item md-small-size-100">
    <md-field v-if="visible">
      <label for="first-name">{{ label }}</label>
      <span class="md-prefix">R$</span>
      <md-input
        v-model="inputValue"
        :name="name"
        type="number"
        :placeholder="placeholder"
        :readonly="readonly"
        :disabled="disabled"
      ></md-input>
      <!-- <md-input
        name="first-name"
        id="first-name"
        autocomplete="given-name"
        v-model="form.firstName"
        :disabled="sending"
      />-->
      <!-- <span class="md-error" v-if="!$v.form.firstName.required">The first name is required</span>
      <span class="md-error" v-else-if="!$v.form.firstName.minlength">Invalid first name</span>-->
    </md-field>
  </div>
</template>
<script>
import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";
import { mapState, mapGetters } from "vuex";
import _ from 'lodash';

export default {
  name: "moneyInput",
  props: ["placeholder", "label", "name", "value", "readonly", "mode"],
  data() {
    return {
      inputName: this.name
    };
  },
  computed: {
    inputValue: {
      get() {
        return this.$store.getters[fullModuleName + "/getData"][this.name];
      },
      set: _.debounce(function(newValue) {
        this.updateStore(newValue);
      }, 500)
    },
    ...mapState(fullModuleName, {
      visible(state) {
        return state.fields[this.name].visible;
      }
    }),
    ...mapGetters(fullModuleName, {
      visibilityTriggers: "getVisibilityTriggers",
      fields: "getFields"
    }),
    disabled() {
      return this.name === "_id";
    }
  },
  methods: {
    updateStore(newValue) {
      this.$store.dispatch(fullModuleName + "/changeDataProperty", {
        property: this.name,
        value: newValue
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

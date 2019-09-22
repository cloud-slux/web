<template>
  <div class="md-layout-item md-small-size-100">
    <md-datepicker v-model="inputValue" v-if="visible" md-immediately>
      <label>{{ placeholder }}</label>
    </md-datepicker>
  </div>
</template>
<script>
import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";
import { mapState, mapGetters } from "vuex";

export default {
  name: "datePickerInput",
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
      set(newValue) {
        this.$store.dispatch(fullModuleName + "/changeDataProperty", {
          property: this.name,
          value: newValue
        });
      }
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

<template>
  <div class="md-layout-item md-small-size-100">
    <md-field v-if="visible">
      <label for="first-name">{{ label }}</label>
      <md-input
        :value="inputValue"
        :name="name"
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

export default {
  name: "textInput",
  props: ["placeholder", "label", "name", "value", "readonly", "mode"],
  data() {
    return {
      inputName: this.name
    };
  },
  computed: {
    ...mapState(fullModuleName, {
      inputValue(state) {
        return state.data[this.name];
      },
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
  watch: {
    inputValue(val) {
      this.debouncedUpdateStore();
    }
  },
  created: function() {
    this.debouncedUpdateStore = _.debounce(this.updateStore, 500);
  },
  methods: {
    updateStore() {
      this.$store.dispatch(fullModuleName + "/changeDataProperty", {
        property: this.name,
        value: this.inputValue
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

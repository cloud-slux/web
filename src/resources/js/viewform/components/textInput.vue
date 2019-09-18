<template>
  <div class="md-layout-item md-small-size-100">
    <md-field v-if="visible" >
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
import { mapState } from "vuex";

export default {
  name: "textInput",
  props: ["placeholder", "label", "name", "value", "readonly", "mode"],
  data() {
    return {
      inputName: this.name,
      visible: true,
    };
  },
  computed: {
    ...mapState(fullModuleName, {
      inputValue(state) {
        return state.data[this.name];
      }
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
  }
};
</script>

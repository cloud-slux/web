<template>
  <div class="md-layout-item md-small-size-100">
    <md-field>
      <label :for="name">{{ label }}</label>
      <md-select v-model="inputValue" :name="name" :id="name" :disabled="readonly">
        <md-option
          v-for="option in options"
          :key="option.value"
          v-bind:value="option.value"
        >{{ option.display }}</md-option>
      </md-select>
    </md-field>
  </div>
</template>
<script>
import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

export default {
  name: "selectInput",
  props: ["label", "name", "value", "readonly", "mode", "maps"],
  data() {
    return {
      inputValue: this.value,
      options: []
    };
  },
   watch: {
    inputValue(val) {
      this.updateStore();
    }
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

    if (this.maps.hasOwnProperty(this.name)) {
      const map = this.maps[this.name];
      for (var value in map) {
        const display = map[value];
        this.options.push({
          value: value,
          display: display
        });
      }
    }
  }
};
</script>


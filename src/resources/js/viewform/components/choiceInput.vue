<template>
  <div class="md-layout md-gutter">
    <div class="md-layout-item" v-for="option in options" :key="option.value">
      <md-radio v-model="inputValue" v-bind:value="option.value">{{ option.display }}</md-radio>
    </div>
  </div>
</template>
<script>
import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

export default {
  name: "choiceInput",
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


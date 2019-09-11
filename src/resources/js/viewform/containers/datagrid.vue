<script>
import { mapState, mapActions } from "vuex";
import componentWidthDynamicModule from "../../utils/componentWithDynamicModule";
import { moduleName } from "../../helpers/dynamicModule";

Vue.component("data-grid", {
  extends: componentWidthDynamicModule(moduleName()),
  props: {
    fields: String,
    maps: String,
    singularName: String
  },
  render() {
    return this.$slots.loading[0];
  },
  mounted() {
    const jsonFields = JSON.parse(this.fields);
    const jsonMaps = JSON.parse(this.maps);
    this.$store.dispatch(moduleName() + "/changeFields", jsonFields);
    this.$store.dispatch(moduleName() + "/changeMaps", jsonMaps);
    this.$store.dispatch(
      moduleName() + "/changeSingularName",
      this.singularName
    );
  }
});

export default {};
</script>

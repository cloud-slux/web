<script>
import { mapState, mapActions, mapGetters } from "vuex";

import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

Vue.component("form-generator", {
  props: ['url'],
  computed: {
    ...mapState(fullModuleName, {
      formData: state => state.data,
      loading: state => state.loading,
      mode: state => state.mode
    }),
    ...mapGetters(fullModuleName, {
      schema: "getSchema",
      createSchema: "getCreateSchema",
      maps: "getMaps",
      pickers: "getPickers"
    })
  },
  mounted() {
    this.changeApiUrl(this.url);
  },
  render() {
    if (this.loading) {
      return this.$slots.loading[0];
    }

    const readOnly = this.mode === "show";

    const modeSchema = this.mode === "create" ? this.createSchema : this.schema;

    return this.$scopedSlots.default({
      formData: this.formData,
      schema: modeSchema,
      mode: this.mode,
      maps: this.maps,
      readOnly: readOnly,
      getPickerRouteFromField: this.getPickerRouteFromField,
      getPickerSchemaFromField: this.getPickerSchemaFromField,
      getPickerHiddenFieldsFromField: this.getPickerHiddenFieldsFromField,
      getPickerHooksFromField: this.getPickerHooksFromField,
      getPickerPreFilterFromField: this.getPickerPreFilterFromField,
      getPickerDisplayExpressionFromField: this.getPickerDisplayExpressionFromField,
    });
  },
  methods: {
    ...mapActions(fullModuleName, ["changeApiUrl"]),
    getPickerRouteFromField(field) {
      let pickerRoute = "";
      if (this.pickers.hasOwnProperty(field.name)) {
        pickerRoute = this.pickers[field.name].pickerRoute;
      }
      return pickerRoute;
    },
    getPickerSchemaFromField(field) {
      let pickerSchema = {};

      if (this.pickers.hasOwnProperty(field.name)) {
        pickerSchema = this.pickers[field.name].pickerSchema;
      }

      return pickerSchema;
    },
    getPickerHiddenFieldsFromField(field) {
      let pickerHiddenFields = [];

      if (this.pickers.hasOwnProperty(field.name)) {
        pickerHiddenFields = this.pickers[field.name].pickerHiddenFields;
      }

      return pickerHiddenFields;
    },
    getPickerHooksFromField(field) {
      let pickerHooks = [];

      if (this.pickers.hasOwnProperty(field.name)) {
        pickerHooks = this.pickers[field.name].pickerHooks;
      }

      return pickerHooks;
    },
    getPickerPreFilterFromField(field){
      let pickerPreFilter = "";
      if (this.pickers.hasOwnProperty(field.name)) {
        pickerPreFilter = this.pickers[field.name].pickerPreFilter;
      }
      return pickerPreFilter;
    },
    getPickerDisplayExpressionFromField(field){
      let pickerDisplayExpression = "";
      if (this.pickers.hasOwnProperty(field.name)) {
        pickerDisplayExpression = this.pickers[field.name].pickerDisplayExpression;
      }
      return pickerDisplayExpression;
    }
  }
});

export default {};
</script>

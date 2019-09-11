

<script>
// import formGenerator from "./formgenerator";
import { mapState, mapActions, mapGetters } from "vuex";
import componentWidthDynamicModule from "../../utils/componentWithDynamicModule";
import { moduleName, uriID } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

Vue.component("multi-form", {
  extends: componentWidthDynamicModule(fullModuleName),
  props: {
    fields: String,
    maps: String,
    pickers: String,
    singularName: String
  },
  computed: {
  ...mapState(moduleName(), {
      apiCalling: state => state.apiCalling
    })
  },
  render() {
    return this.$slots.loading[0];
  },
  mounted() {

    const jsonFields = JSON.parse(this.fields);
    const jsonMaps = JSON.parse(this.maps);
    const jsonPickers = JSON.parse(this.pickers);

    this.$store.dispatch(fullModuleName + "/changeFields", jsonFields);
    this.$store.dispatch(fullModuleName + "/changeMaps", jsonMaps);
    this.$store.dispatch(fullModuleName + "/changePickers", jsonPickers);

    this.$store.dispatch(
        fullModuleName + "/changeSingularName",
      this.singularName
    );

    let uri = uriID();

    if(uri === 'create')
    {
        this.$store.dispatch(fullModuleName + "/changeMode", 'create');
    }else{
        if(uri.startsWith('edit')){
            this.$store.dispatch(fullModuleName + "/changeMode", 'edit');
            uri = uri.replace('edit', '');
        }

        this.apiFetch(uri);
    }
  },
  methods: {
    ...mapActions(fullModuleName, ["apiFetch"])
  }
});

export default {};
</script>

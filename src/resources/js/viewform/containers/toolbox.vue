<template>
  <div class="md-layout md-gutter">
    <div class="md-layout-item">
      <md-field>
        <label>Pesquise na Tabela</label>
        <md-input v-model="search"></md-input>
      </md-field>
    </div>

    <div class="md-layout-item">
      <md-button class="md-primary md-raised" :href="createItem()" >Cadastrar {{ singularName}}</md-button>
    </div>
  </div>
</template>


<script>
import { mapState, mapActions } from "vuex";
import { moduleName } from "../../helpers/dynamicModule";

export default {
  name: "toolBox",
  data() {
    return {
      search: ""
    };
  },
  computed: {
    ...mapState(moduleName(), {
      singularName: state => state.singularName
    })
  },
  created: function() {
    this.debouncedChangeToolFilter = _.debounce(this.changeToolFilter, 300);
  },
  watch: {
    search: function(val) {
      this.debouncedChangeToolFilter(val);
    }
  },
  methods: {
    createItem() {
      return moduleName() + "/create";
    },
    changeToolFilter() {
      this.$store.dispatch(moduleName() + "/changeToolFilter", this.search);
    }
  }
};
</script>

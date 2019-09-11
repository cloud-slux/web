<template>
  <md-card-actions>
    <md-button :href="voltar()">Voltar</md-button>
    <md-button type="submit" v-if="mode === 'edit'" class="md-primary" @click.native="apiUpdate()">Editar</md-button>
    <md-button
      type="submit"
      v-if="mode === 'create'"
      class="md-primary"
      @click.native="apiCreate()"
    >Criar</md-button>
  </md-card-actions>
</template>


<script>
import { mapState, mapActions, mapGetters } from "vuex";

import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

export default {
  mame: "formBar",
  methods: {
    ...mapActions(fullModuleName, ["apiCreate", "apiUpdate"]),
    voltar() {
      return moduleName();
    }
  },
  computed: {
    ...mapState(fullModuleName, {
      mode: state => state.mode
    })
  }
};
</script>

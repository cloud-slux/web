<template>
  <md-progress-bar md-mode="indeterminate" v-if="apiCalling" />
</template>


<script>
import { mapState, mapActions, mapGetters } from "vuex";

import { moduleName } from "../../helpers/dynamicModule";
const fullModuleName = moduleName() + "/multiform";

export default {
  mame: "progressBar",
   computed: {
    ...mapState(fullModuleName, {
      apiCalling: state => state.apiCalling
    })
  },
  mounted() {
    this.$store.subscribe((mutation, state) => {
      if(mutation.type === fullModuleName + '/API_CALL')
      {
        let returnString = '';

        let pickCount = 0;

        for (var property in mutation.payload.data) {
          if (mutation.payload.data.hasOwnProperty(property)) {
            const value = mutation.payload.data[property];
            if (pickCount === 0) {
              returnString += ' ID: '+ value;
              pickCount++;
            } else if (pickCount === 1) {
              returnString += ` | ${value} `;
              break;
            }

          }
        }

        this.$bvToast.toast(returnString, {
        title:  mutation.payload.message,
        toaster: "b-toaster-top-center",
        autoHideDelay: 2000,
        variant: "success"
        });
      }
    });
  },
  methods: {
    ...mapActions(fullModuleName, ["emptyData"])
  }
};
</script>

<script>
import { mapState, mapActions, mapGetters } from "vuex";
import socket from "socket.io-client";
import { moduleName } from "../../helpers/dynamicModule";

//const io = socket("http://api.slux.net.br");

Vue.component("table-blade", {
  props: ['url'],
  data() {
    return {
      deleteModalActive: false,
      selectedItem: {}
    };
  },
  computed: {
    ...mapState(moduleName(), {
      loading: state => state.loading,
      page: state => state.page,
      limit: state => state.limit,
      response: state => state.response
    }),
    ...mapGetters(moduleName(), [
      "getBrowsedFields",
      "getSingularName",
      "getMaps"
    ])
  },
  methods: {
    ...mapActions(moduleName(), ["apiFetch", "apiDelete", "changeApiUrl"]),
    onDeleteModalActive(item) {
      this.deleteModalActive = true;
      this.selectedItem = item;
    },
    onDeleteModalConfirm() {
      if (!this.selectedItem) {
        console.log("eita bixiga");
      }

      const { _id } = this.selectedItem;

      if (!_id) {
        console.log("eita bixiga2");
      }

      this.deleteModalActive = false;
      this.selectedItem = {};

      this.apiDelete(_id);
    },
    onDeleteModalCancel() {
      this.deleteModalActive = false;
      this.selectedItem = {};
    },
    formatItem(item) {
      let returnString = "<span>";

      let pickCount = 0;

      for (var property in this.getBrowsedFields) {
        if (this.getBrowsedFields.hasOwnProperty(property)) {
          const field = this.getBrowsedFields[property];
          if (field.browsed) {
            if (pickCount === 0) {
              returnString += `${field.alias} = <strong> ${
                item[field.name]
              } </strong>`;
              pickCount++;
            } else if (pickCount === 1) {
              returnString += ` |  ${field.alias} = <strong> ${
                item[field.name]
              } </strong>`;
              break;
            }
          }
        }
      }
      returnString += "</span>";
      return returnString;
    },
    showItem(item) {
      return moduleName() + "/" + item._id;
    },
    editItem(item) {
      return moduleName() + "/edit" + item._id;
    },
    createItem() {
      return moduleName() + "/create";
    },
    showCell(item, browsedField, maps) {
      if (browsedField.name === "_id") {
        return item[browsedField.name].substr(-3);
      } else {
        let cellValue = item[browsedField.name];
        if (browsedField.type === "choice" || browsedField.type === "select") {
          if (maps.hasOwnProperty(browsedField.name)) {
            const map = maps[browsedField.name];
            if (map.hasOwnProperty(cellValue)) {
              cellValue = map[cellValue];
            }
          }
        } else {
          cellValue = item[browsedField.name];
        }
        return cellValue;
      }
    }
  },
  render() {
    if (this.loading) {
      return this.$slots.loading[0];
    }

    return this.$scopedSlots.default({
      response: this.response.data,
      pagenumber: this.page,
      pagelimit: this.limit,
      apiFetch: this.apiFetch,
      browsedFields: this.getBrowsedFields,
      singularName: this.getSingularName,
      maps: this.getMaps,
      deleteModalActive: this.deleteModalActive,
      selectedItem: this.selectedItem,
      onDeleteModalActive: this.onDeleteModalActive,
      onDeleteModalCancel: this.onDeleteModalCancel,
      onDeleteModalConfirm: this.onDeleteModalConfirm,
      formatItem: this.formatItem,
      showItem: this.showItem,
      editItem: this.editItem,
      createItem: this.createItem,
      showCell: this.showCell
    });
  },
  mounted() {
    // io.on(moduleName(), data => {
    //   this.$bvToast.toast(data.message, {
    //     title: "Aviso",
    //     toaster: "b-toaster-top-center",
    //     autoHideDelay: 2000,
    //     variant: data.class
    //   });
    // });
    this.changeApiUrl(this.url);
    this.apiFetch(1);
    //this.$store.dispatch(name +'apiFetch');
  }
});

export default {};
</script>

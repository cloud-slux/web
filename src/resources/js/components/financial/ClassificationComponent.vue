
<template>
  <div id="classificationsrec">
    <div class="row justify-content-center">
      <div v-bind:class="{ succmsg: succmsg }">
        <div class="col-md-12 col-lg-12">
          <div class="alert alert-success cusmsg">{{ actionmsg }}</div>
        </div>
      </div>
      <div class="col-md-12">
        <!-- Button trigger modal -->

        <!-- Modal -->

        <div
          class="modal fade"
          id="exampleModal"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModalLabel"
          aria-hidden="true"
          v-bind:class="{ showmodal:showmodal }"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-description" id="exampleModalLabel">Modal description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form
                  method="classification"
                  name="addclassification"
                  id="addclassification"
                  action="#"
                  @submit.prevent="updateclassification"
                >
                  <div class="form-group">
                    <label for="description">Descrição</label>
                    <input
                      type="text"
                      name="description"
                      id="description"
                      class="form-control"
                      placeholder="Descrição"
                      v-model="classification.description"
                    >
                  </div>
                  <div class="form-group">
                    <label for="author">Tipo</label>
                    <select
                      class="form-control"
                      name="author"
                      id="author"
                      v-model="classification.type"
                    >
                      <option value="C">Credito</option>
                      <option value="D">Debito</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label for="author">Classe</label>
                    <select
                      class="form-control"
                      name="author"
                      id="author"
                      v-model="classification.class"
                    >
                      <option value="A">Analitica</option>
                      <option value="S">Sintetica</option>
                    </select>
                  </div>
                  <div class="form-group text-right">
                    <button class="btn btn-success">Alterar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <div
          class="modal fade"
          id="exampleModal2"
          tabindex="-1"
          role="dialog"
          aria-labelledby="exampleModal2Label"
          aria-hidden="true"
        >
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-description" id="exampleModalLabel">Modal description</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <p>Are you sure want to delete the record?</p>
                </div>
                <div class="form-group text-center">
                  <button class="btn btn-success" v-on:click="hideModal()">Cancel</button>
                </div>
                <div class="form-group text-center">
                  <button class="btn btn-success" v-on:click="deleteclassification()">Ok</button>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-header">Lista de Classificações</div>
          <div class="card-body">
            <table class="table table-striped" v-bind:pagenumber="pagenumber">
              <thead>
                <tr>
                  <th scope="col">Código</th>
                  <th scope="col">Descrição</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Classe</th>
                  <th scope="col">Código Pai</th>
                  <th scope="col" colspan="2">Action</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="classification in laravelData.data" :key="classification._id">
                  <th scope="row">{{ classification.code }}</th>
                  <td>{{ classification.description }}</td>
                  <td>{{ classification.type }}</td>
                  <td>{{ classification.class }}</td>
                  <td>{{ classification.codeParent }}</td>
                  <td>
                    <a
                      href=""
                      v-on:click="editclassification(classification._id)"
                      data-target="#exampleModal"
                      data-toggle="modal"
                      v-bind:description="classification.description"
                    >Editar</a>
                  </td>
                  <td>
                    <a
                      href="#"
                      data-target="#exampleModal2"
                      v-on:click="deleteId(classification._id)"
                      data-toggle="modal"
                      v-bind:id="id"
                    >Excluir</a>
                  </td>
                </tr>
              </tbody>
              <pagination
                :data="laravelData"
                :limit="2"
                @pagination-change-page="classificationLists"
              >
                <span slot="prev-nav">&lt; Anterior</span>
                <span slot="next-nav">Próximo' &gt;</span>
              </pagination>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: ["apiUrl"],
  data() {
    return {
      classification: {
        _id: "",
        description: "",
        code: "",
        class: "",
        parent: "",
        codeParent: "",
        createdAt: ""
      },
      laravelData: {},
      id: "",
      succmsg: true,
      showmodal: false,
      pagenumber: 1,
      perpage: 15,
      actionmsg: ""
    };
  },
  methods: {
    classificationLists(page) {
      if (typeof page === "undefined") {
        page = 1;
      }
      this.$http
        //.get("http://127.0.0.1:8081/financial/classification?page=" + page)
        //.get("http://127.0.0.1:8081/financial/classification")
        .get(this.apiUrl + "?page=" + page + "&limit=" + this.perpage)
        .then(response => {
          //this.classifications = response.data.data;
          this.laravelData = response.data;
          this.pagenumber = page;
        });
    },
    editclassification(classificationId) {
      this.$http.get(this.apiUrl + classificationId).then(data => {
        this.classification.description = data.data.data.description;
        this.classification.classification_content =
          data.data.data.classification_content;
        this.classification.email = data.data.data.email;
        this.classification.author = data.data.data.author;
        this.id = classificationId;
      });
    },
    updateclassification() {
      this.$http
        .put(this.apiUrl + this.id, {
          description: this.classification.description,
          classification_content: this.classification.classification_content,
          email: this.classification.email,
          author: this.classification.author
        })
        .then(data => {
          this.succmsg = false;
          console.log(data);
          this.classification.description = "";
          this.classification.classification_content = "";
          this.classification.email = "";
          this.classification.author = "";
          var self = this;
          setTimeout(function() {
            self.succmsg = true;
          }, 3000);
          this.actionmsg = "Data updated successfully";
          $("#exampleModal").modal("hide");
          this.classificationLists(this.pagenumber);
        });
    },
    deleteId(classificationId) {
      this.id = classificationId;
    },
    deleteclassification() {
      this.$http
        .delete("http://127.0.0.1:8081/financial/classification" + this.id)
        .then(data => {
          this.succmsg = false;
          var self = this;
          setTimeout(function() {
            self.succmsg = true;
          }, 3000);

          this.actionmsg = "Data deleted successfully";
          this.classifiaLists(this.pagenumber);
          $("#exampleModal2").modal("hide");
        });
    },
    hideModal() {
      $("#exampleModal2").modal("hide");
    }
  },
  mounted() {
    this.classificationLists();
  }
};
</script>
<style scoped>
.succmsg {
  display: none;
}
.showmodal {
  display: none !important;
  opacity: 0;
}
</style>

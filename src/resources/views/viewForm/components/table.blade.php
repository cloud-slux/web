<table-blade url="{!! $apiUrl !!}">
  <div slot="loading">
    <!-- <md-progress-spinner :md-diameter="100" :md-stroke="10" md-mode="indeterminate"></md-progress-spinner> -->
    <div class="d-flex justify-content-center">
      <div class="spinner-border  text-primary"  style="width: 6rem; height: 6rem;"  role="status">
        <span class="sr-only">Loading...</span>
      </div>
    </div>
  </div>
  <div
    slot-scope="{ response: laravelData, pagenumber, pagelimit, apiFetch, browsedFields, singularName, maps, deleteModalActive, selectedItem, onDeleteModalActive, onDeleteModalCancel, onDeleteModalConfirm, formatItem, showItem, editItem, createItem, showCell }"
    class="columns is-mobile">
    <md-table v-model="laravelData.data" md-sort="_id" md-sort-order="asc" md-card md-fixed-header>

      <md-table-empty-state md-label="Nenhum Registro Encontrado"
        :md-description="`Nenhum(a) '${singularName}' encontrado. Tente outras condições de pesquisa ou cadastre um novo(a).`">
        <md-button class="md-primary md-raised"  :href="createItem()">Cadastrar @{{ singularName }} </md-button>
      </md-table-empty-state>

      <md-table-row slot="md-table-row" slot-scope="{ item }">
        <md-table-cell v-for="browsedField in browsedFields" :md-label="browsedField.shortAlias"
          :md-sort-by="browsedField.name" :key="browsedField.name">
          @{{ showCell(item, browsedField, maps) }}
        </md-table-cell>

        <md-table-cell>
          <md-menu md-size="big" md-direction="bottom-end">
            <md-button class="md-icon-button" md-menu-trigger>
              <md-icon>menu</md-icon>
            </md-button>

            <md-menu-content>
              <md-menu-item>
                <span>Visualizar</span>
                <md-button class="md-raised md-success md-icon-button" :href="showItem(item)">
                  <md-icon>ballot</md-icon>
                </md-button>
              </md-menu-item>

              <md-menu-item>
                <span>Editar</span>
                <md-button class="md-raised md-primary md-icon-button" :href="editItem(item)">
                  <md-icon>edit</md-icon>
                </md-button>
              </md-menu-item>

              <md-menu-item>
                <span>Deletar</span>
                <md-button class="md-raised md-accent md-icon-button" @click.native="onDeleteModalActive(item)">
                  <md-icon>delete</md-icon>
                </md-button>
              </md-menu-item>
            </md-menu-content>
          </md-menu>
        </md-table-cell>
      </md-table-row>
    </md-table>

    <pagination :data="laravelData" :limit="pagelimit" align="center" @pagination-change-page="apiFetch">
      <span slot="prev-nav">&lt;</span>
      <span slot="next-nav">&gt;</span>
    </pagination>

    <md-dialog-confirm :md-active.sync="deleteModalActive"
      :md-title="`Deseja Realmente Excluir este(a) ${ singularName } ?`"
      :md-content="`O registro  ${ formatItem(selectedItem) } de  ${ singularName } selecionado será <strong>excluído</strong> do sistema.`"
      md-confirm-text="Sim" md-cancel-text="Não" @md-cancel="onDeleteModalCancel" @md-confirm="onDeleteModalConfirm" />
  </div>
</table-blade>

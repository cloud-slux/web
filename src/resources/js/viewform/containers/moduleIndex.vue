
<template>
  <div class="container">
    <div class="page-container">
      <md-app>
        <md-app-toolbar class="md-primary" md-elevation="0">
          <md-button class="md-icon-button" @click="toggleMenu" v-if="!menuVisible">
            <md-icon>menu</md-icon>
          </md-button>
          <span class="md-title">{{ name }}</span>
        </md-app-toolbar>

        <md-app-drawer :md-active.sync="menuVisible" md-persistent="mini">
          <md-toolbar class="md-transparent" md-elevation="0">
            <span>Menu de Navegação</span>

            <div class="md-toolbar-section-end">
              <md-button class="md-icon-button md-dense" @click="toggleMenu">
                <md-icon>keyboard_arrow_left</md-icon>
              </md-button>
            </div>
          </md-toolbar>

          <md-list>
            <md-list-item v-for="(form, index) in moduleForms" :key="index">
                <md-button class="md-raised md-success md-icon-button" style="padding-left:0px;margin-left:0px;" :href="form.route">
                    <md-icon>{{form.icon}}</md-icon>
                    <md-tooltip v-if='!menuVisible' md-direction="right">{{form.name}}</md-tooltip>
                </md-button>
              <span class="md-list-item-text">{{form.name}}</span>
            </md-list-item>
          </md-list>
        </md-app-drawer>

        <md-app-content>
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Error quibusdam, non molestias et! Earum magnam,
          similique, quo recusandae placeat dicta asperiores modi sint ea.

        </md-app-content>
      </md-app>
    </div>
  </div>
</template>

<script>
export default {
  name: "moduleIndex",
  props: ["name", "forms"],
  data() {
    return {
      menuVisible: false,
      moduleForms: []
    };
  },
  methods: {
    toggleMenu() {
      this.menuVisible = !this.menuVisible;
    }
  },
  mounted() {
    const json = JSON.parse(this.forms);
    this.moduleForms = json;
  }
};
</script>


<style lang="scss" scoped>
.md-app {
  min-height: 350px;
  border: 1px solid rgba(#000, 0.12);
}

// Demo purposes only
.md-drawer {
  width: 330px;
  max-width: calc(100vw - 125px);
}
</style>

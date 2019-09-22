import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const namespaced = true;

export default {
  namespaced,
  state () {
    return {
      loading: true,
      data: null,
      fields: {},
      defaults: {},
      maps: {},
      pickers: {},
      visibilityTriggers: {},
      singularName: '',
      mode: 'show',
      apiUrl: '',
      apiCalling: false,
      apiCallObject: {},
    }
  },
  actions,
  getters,
  mutations
};

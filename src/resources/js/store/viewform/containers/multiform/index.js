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
      maps: {},
      pickers: {},
      singularName: '',
      mode: 'show',
      apiCalling: false,
      apiCallObject: {},
    }
  },
  actions,
  getters,
  mutations
};

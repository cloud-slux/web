import actions from './actions';
import getters from './getters';
import mutations from './mutations';

const namespaced = true;

export default {
  namespaced,
  state () {
    return {
      loading: true,
      page: 1,
      limit: 5,
      response: null,
      originalData: null,
      toolFilter: '',
      queryFilter: '',
      fields: {},
      maps: {},
      singularName: ''
    }
  },
  actions,
  getters,
  mutations
};

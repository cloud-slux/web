import types from './types';
import { moduleName } from "../../../../helpers/dynamicModule";
import { getUsedFields } from './getters';

//método privado.
const checkVisible = (commit, state) => {
    for (var visibilityTrigger in state.visibilityTriggers) {
        state.visibilityTriggers[visibilityTrigger].behaviors.forEach(behavior => {
            if (behavior.value == state.data[visibilityTrigger]) {
              for (var field in state.fields) {
                if (state.fields.hasOwnProperty(field)) {
                  state.fields[
                    field
                  ].visible = !behavior.invisibleFields.includes(field);
                }
              }
            }
          });


        commit(types.CHANGE_FIELDS, state.fields);
    }
};

const apiFetch = ({ commit, state }, _id = '') => {
    if (state.loading) {
        commit(types.LOADING);
    }

    let fullurl = state.apiUrl + moduleName() + '/' + _id;

    // console.log(fullurl);

    axios.get(fullurl, { crossdomain: true }).then(response => {
        commit(types.SUCCESS, response.data);

        checkVisible(commit, state);
    });
};

const emptyData = ({ commit, state }) => {
    const usedFields = getUsedFields(state);
    let emptyObject = {};

    for (var property in usedFields) {
        if (state.fields.hasOwnProperty(property)) {
            const field = usedFields[property];
            if(state.defaults.hasOwnProperty(field.name)){
                emptyObject[field.name] = state.defaults[field.name];
            }else{
                if(field.type == 'datepicker'){
                    emptyObject[field.name] = new Date(Date.now()).toISOString().split('T')[0];
                }else{
                    emptyObject[field.name] = '';
                }
            }
        }
    }

    commit(types.SUCCESS, emptyObject);
    checkVisible(commit, state);
};

const apiCreate = ({ commit, state }) => {
    let fullurl = state.apiUrl + moduleName();

    let postObject = Object.assign({}, state.data);
    delete postObject._id;

    commit(types.API_CALLING);

    axios.post(fullurl, postObject, { crossdomain: true }).then(response => {
        const apiCallObject = { message: `o registro de ${state.singularName} foi criado com Sucesso!`, data: response.data };
        commit(types.API_CALL, apiCallObject);
    });
};

const apiUpdate = ({ commit, state }) => {
    let fullurl = state.apiUrl + moduleName();

    commit(types.API_CALLING);

    axios.put(fullurl, state.data, { crossdomain: true }).then(response => {
        const apiCallObject = { message: `o registro de ${state.singularName} foi alterado com Sucesso!`, data: response.data };
        commit(types.API_CALL, apiCallObject);
    });
};

const changeFields = ({ commit, state }, fields = {}) => {
    if (state.fields != fields) {
        commit(types.CHANGE_FIELDS, fields);
    }
};

const changeDefaults = ({ commit, state }, defaults = {}) => {
    if (state.defaults != defaults) {
        commit(types.CHANGE_DEFAULTS, defaults);
    }
};

const changeMaps = ({ commit, state }, maps = {}) => {
    if (state.maps != maps) {
        commit(types.CHANGE_MAPS, maps);
    }
};

const changePickers = ({ commit, state }, pickers = {}) => {
    if (state.pickers != pickers) {
        commit(types.CHANGE_PICKERS, pickers);
    }
};

const changeVisibilityTriggers = ({ commit, state }, visibilityTriggers = {}) => {
    if (state.visibilityTriggers != visibilityTriggers) {
        commit(types.CHANGE_VISIBILITY_TRIGGERS, visibilityTriggers);
    }
};

const changeSingularName = ({ commit, state }, singularName = '') => {
    if (state.singularName != singularName) {
        commit(types.CHANGE_SINGULAR_NAME, singularName);
    }
};

const changeMode = ({ commit, dispatch, state }, mode = 'show') => {
    if (state.mode != mode) {
        commit(types.CHANGE_MODE, mode);
    }

    if (mode === 'create') {
        dispatch('emptyData');
    }
};

const changeApiUrl = ({ commit, state }, apiUrl = '') => {
    if (state.apiUrl != apiUrl) {
        commit(types.CHANGE_API_URL, apiUrl);
    }
};

const changeDataProperty = ({ commit, state }, propertyValue) => {
    if (state.data[propertyValue.property] != propertyValue.value) {
        commit(types.CHANGE_DATA_PROPERTY, propertyValue);
    }
};

export default {
    apiFetch,
    emptyData,
    apiCreate,
    apiUpdate,
    changeFields,
    changeDefaults,
    changeMaps,
    changePickers,
    changeSingularName,
    changeMode,
    changeApiUrl,
    changeDataProperty,
    changeVisibilityTriggers
};

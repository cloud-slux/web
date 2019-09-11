import types from './types';
import { moduleName } from "../../../../helpers/dynamicModule";
import { getUsedFields } from './getters';

const apiFetch = ({ commit, state }, _id = '') => {
    if (state.loading) {
        commit(types.LOADING);
    }

    let fullurl = 'http://localhost:8081' + moduleName() + '/' + _id;

    // console.log(fullurl);

    axios.get(fullurl, { crossdomain: true }).then(response => {
        commit(types.SUCCESS, response.data);
    });
};

const emptyData = ({ commit, state }) => {
    const usedFields = getUsedFields(state);
    let emptyObject = {};

    for (var property in usedFields) {
        if (state.fields.hasOwnProperty(property)) {
            const field = usedFields[property];
            emptyObject[field.name] = '';
        }
    }

    commit(types.SUCCESS, emptyObject);
};

const apiCreate = ({ commit, state }) => {
    let fullurl = 'http://localhost:8081' + moduleName();

    let postObject = Object.assign({}, state.data);
    delete postObject._id;

    commit(types.API_CALLING);

    axios.post(fullurl, postObject, { crossdomain: true }).then(response => {
        const apiCallObject = { message: `o registro de ${state.singularName} foi criado com Sucesso!` , data: response.data};
        commit(types.API_CALL, apiCallObject);
    });
};

const apiUpdate = ({ commit, state }) => {
    let fullurl = 'http://localhost:8081' + moduleName();

    commit(types.API_CALLING);

    axios.put(fullurl, state.data, { crossdomain: true }).then(response => {
        const apiCallObject = { message: `o registro de ${state.singularName} foi alterado com Sucesso!` , data: response.data};
        commit(types.API_CALL, apiCallObject);
    });
};

const changeFields = ({ commit, state }, fields = {}) => {
    if (state.fields != fields) {
        commit(types.CHANGE_FIELDS, fields);
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

const changeSingularName = ({ commit, state }, singularName = '') => {
    if (state.singularName != singularName) {
        commit(types.CHANGE_SINGULAR_NAME, singularName);
    }
};

const changeMode = ({ commit, dispatch, state }, mode = 'show') => {
    if (state.mode != mode) {
        commit(types.CHANGE_MODE, mode);
    }

    if(mode === 'create'){
        dispatch('emptyData');
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
    changeMaps,
    changePickers,
    changeSingularName,
    changeMode,
    changeDataProperty
};

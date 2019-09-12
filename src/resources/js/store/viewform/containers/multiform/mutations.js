import types from './types';

const success = (state, data) => {
    state.data = data;
    state.loading = false;
};

const loading = state => {
    state.loading = true;
};

const changeFields = (state, fields) => {
    state.fields = fields;
};

const changeMaps = (state, maps) => {
    state.maps = maps;
};

const changePickers = (state, pickers) => {
    state.pickers = pickers;
};

const changeSingularName = (state, singularName) => {
    state.singularName = singularName;
};

const changeMode = (state, mode) => {
    state.mode = mode;
};

const changeDataProperty = (state, propertyValue) => {
    state.data[propertyValue.property] = propertyValue.value;
};

const changeApiUrl= (state, apiUrl) => {
    state.apiUrl = apiUrl;
};

const apiCalling = (state) => {
    state.apiCalling = true;
}

const apiCall = (state, apiCallObject) => {
    state.apiCallObject = apiCallObject;
    state.apiCalling = false;
};

export default {
    [types.SUCCESS]: success,
    [types.LOADING]: loading,
    [types.CHANGE_FIELDS]: changeFields,
    [types.CHANGE_MAPS]: changeMaps,
    [types.CHANGE_PICKERS]: changePickers,
    [types.CHANGE_SINGULAR_NAME]: changeSingularName,
    [types.CHANGE_MODE]: changeMode,
    [types.CHANGE_DATA_PROPERTY]: changeDataProperty,
    [types.CHANGE_API_URL]: changeApiUrl,
    [types.API_CALLING]: apiCalling,
    [types.API_CALL]: apiCall
};

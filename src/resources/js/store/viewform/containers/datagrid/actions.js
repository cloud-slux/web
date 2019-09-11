import types from './types';

const apiFetch = ({ commit, state, dispatch }, page = 1) => {
    if (state.loading) {
        commit(types.LOADING);
    }

    let fullurl =
        'http://localhost:8081' +
        window.location.pathname +
        '?page=' +
        page +
        '&limit=' +
        state.limit;

    if (state.queryFilter != null && state.queryFilter.replace(/\s/g, '').length >= 1) {
        fullurl += '&q=' + state.queryFilter;
    }

    dispatch('changePage', page);

    // console.log(fullurl);

    axios.get(fullurl, { crossdomain: true }).then(response => {
        state.originalData = response.data.data;
        if (state.loading) {
            commit(types.SUCCESS, response);
        } else {
            commit(types.REFRESH, response);
        }

        dispatch('changeToolFilter', state.toolFilter);
    });
};

const apiDelete = ({ dispatch }, _id = '') => {

    let fullurl =
        'http://localhost:8081' +
        window.location.pathname +
        '/' + _id;

        axios.delete(fullurl, { crossdomain: true }).then(response => {
            dispatch('apiFetch', 1);
        });
}

const changeLimit = ({ commit, state }, limit = 5) => {
    if (state.limit != limit) {
        commit(types.CHANGE_LIMIT, limit);
    }
};

const changePage = ({ commit, state }, page = 1) => {
    if (state.page != page) {
        commit(types.CHANGE_PAGE, page);
    }
};

const changeToolFilter = ({ commit, state }, toolFilter = '') => {
    if (state.toolFilter != toolFilter) {
        commit(types.CHANGE_TOOL_FILTER, toolFilter);
    }
};

const changeQueryFilter = ({ commit, state }, queryFilter = '') => {
    if (state.queryFilter != queryFilter) {
        commit(types.CHANGE_QUERY_FILTER, queryFilter);
    }
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

const changeSingularName = ({commit, state}, singularName = '') => {
    if(state.singularName != singularName){
        commit(types.CHANGE_SINGULAR_NAME, singularName);
    }
}

export default {
    apiFetch,
    apiDelete,
    changeLimit,
    changePage,
    changeToolFilter,
    changeQueryFilter,
    changeFields,
    changeMaps,
    changeSingularName
};

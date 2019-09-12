import types from './types';

const success = (state, response) => {
    state.response = response;
    state.loading = false;
};

const refresh = (state, response) => {
    state.response = response;
};

const loading = state => {
    state.loading = true;
};

const changeLimit = (state, limit) => {
    state.limit = limit;
};

const changePage = (state, page) => {
    state.page = page;
};

const changeToolFilter = (state, toolFilter) => {
    state.toolFilter = toolFilter;
    if (toolFilter == null || toolFilter.replace(/\s/g, '').length < 1) {
        state.response.data.data = state.originalData;
    } else {
        state.response.data.data = state.originalData.filter(model => {
            let matched = false;
            for (var property in state.fields) {
                if (state.fields.hasOwnProperty(property)) {
                    const field = state.fields[property];
                    if (field.browsed && !matched) {
                        matched = model[field.name].toLowerCase().includes(toolFilter.toLowerCase());
                    }
                }
            }
            return matched;
        });
    }
};

const changeQueryFilter = (state, queryFilter) => {
    state.queryFilter = queryFilter;
};

const changeFields = (state, fields) => {
    state.fields = fields;
};

const changeMaps = (state, maps) => {
    state.maps = maps;
};

const changeSingularName = (state, singularName) => {
    state.singularName = singularName;
}

const changeApiUrl = (state, apiUrl) => {
    state.apiUrl = apiUrl;
}

export default {
    [types.SUCCESS]: success,
    [types.LOADING]: loading,
    [types.REFRESH]: refresh,
    [types.CHANGE_LIMIT]: changeLimit,
    [types.CHANGE_PAGE]: changePage,
    [types.CHANGE_TOOL_FILTER]: changeToolFilter,
    [types.CHANGE_QUERY_FILTER]: changeQueryFilter,
    [types.CHANGE_FIELDS]: changeFields,
    [types.CHANGE_MAPS]: changeMaps,
    [types.CHANGE_SINGULAR_NAME]: changeSingularName,
    [types.CHANGE_API_URL]: changeApiUrl
};

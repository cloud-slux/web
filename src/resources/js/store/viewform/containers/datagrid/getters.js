const getResponse = state => {
    return state.response;
};

const getPage = state => {
    return state.page;
};

const getLimit = state => {
    return state.limit;
};

const getToolFilter = state => {
    return state.toolFilter;
};

const getQueryFilter = state => {
    return state.queryFilter;
};

const getFields = state => {
    return state.fields;
};

const getBrowsedFields = state => {
    let returnObject = {};
    for (var property in state.fields) {
        if (state.fields.hasOwnProperty(property)) {
            const field = state.fields[property];
            if (field.browsed) {
                returnObject[property] = field;
            }
        }
    }

    return returnObject;
};

const getSingularName = state => {
    return state.singularName;
}

const getMaps = state => {
    return state.maps;
};


export default {
    getResponse,
    getPage,
    getLimit,
    getToolFilter,
    getQueryFilter,
    getFields,
    getBrowsedFields,
    getSingularName,
    getMaps
};

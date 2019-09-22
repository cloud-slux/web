const getFields = state => {
    return state.fields;
};

const getDefaults = state => {
    return state.defaults;
}

const getUsedFields = state => {
    let returnObject = {};
    for (var property in state.fields) {
        if (state.fields.hasOwnProperty(property)) {
            const field = state.fields[property];
            if (field.used) {
                returnObject[property] = field;
            }
        }
    }

    return returnObject;
};

const getSingularName = state => {
    return state.singularName;
};

const getApiUrl = state => {
    return state.apiUrl;
};

const getSchema = state => {
    let schema = [];

    const usedFields = getUsedFields(state);

    for (var property in usedFields) {
        if (state.fields.hasOwnProperty(property)) {
            const field = usedFields[property];
            schema.push({
                fieldType: field.type + '-input',
                name: field.name,
                placeholder: field.alias,
                label: field.alias
            });
        }
    }
    return schema;
};

const getCreateSchema = state => {
    let schema = getSchema(state);
    for( var i = 0; i < schema.length; i++){
        if ( schema[i].name === '_id') {
           schema.splice(i, 1);
        }
     }

    return schema;
};

const getMaps = state => {
    return state.maps;
};

const getPickers = state => {
    return state.pickers;
};

const getVisibilityTriggers = state => {
    return state.visibilityTriggers;
}

export default {
    getFields,
    getUsedFields,
    getDefaults,
    getSingularName,
    getSchema,
    getCreateSchema,
    getMaps,
    getPickers,
    getApiUrl,
    getVisibilityTriggers,
};

export {getUsedFields}

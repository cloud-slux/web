function moduleName () {
    let moduleName = window.location.pathname;
    if(moduleName.endsWith('/')){
        moduleName = moduleName.substring(0, moduleName.length-1);
    }

    moduleName = moduleName.substring(1);

    let uris = moduleName.split('/');
    for( var i = 0; i < uris.length; i++){
        if ( uris[i].length > 23 || uris[i] === 'create' ) {
            uris.splice(i, 1);
        }
     }

     moduleName = '/'+ uris.join('/');

    return moduleName;
};

function uriID () {
    let moduleName = window.location.pathname;
    if(moduleName.endsWith('/')){
        moduleName = moduleName.substring(0, moduleName.length-1);
    }

    moduleName = moduleName.substring(1);

    let uris = moduleName.split('/');
    let id = uris.pop();

    return id;
};

export { moduleName, uriID };


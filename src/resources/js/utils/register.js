import dataGridModule from '../store/viewform/containers/datagrid/index';
import multiFormModule from '../store/viewform/containers/multiform/index';
export default (name, store) => {
    if (name.includes('multiform')) {
        store.registerModule(name, multiFormModule);
    } else {
        store.registerModule(name, dataGridModule);
    }
};

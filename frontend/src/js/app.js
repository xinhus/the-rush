
let globalSorting = [];

const searchPlayerByName = () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('searchPlayerByName')).hide();
    setPageAsLoading();
    const myInput = document.getElementById('playerNameField');
    createRowsForRecordSet(retrieveDataFromApi(myInput.value, globalSorting));
    return false;
}

const setOrderBy = (fieldName, order) => {
    let found = false;
    globalSorting = globalSorting.map( field => {
        if (field.name === fieldName) {
            field.order = order;
            found = true;
        }
        return field
    });

    if (found === false) {
        globalSorting.push({
            name: fieldName,
            order: order
        });
    }
    searchPlayerByName();
}

const removeOrderBy = (fieldName) => {
    globalSorting = globalSorting.filter( item => item.name !== fieldName)
    searchPlayerByName();
}

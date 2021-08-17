
let globalSorting = [];
let currentPage = 1;
const recordsPerPage = 10;
let apiServer = "http://localhost:8080";

const searchPlayerByName = () => {
    const myInput = document.getElementById('playerNameField');
    setPageAsLoading();
    createRowsForRecordSet(retrieveDataFromApi(apiServer, myInput.value, globalSorting, currentPage, recordsPerPage));
    return false;
}

const setOrderBy = (fieldName, order, element) => {
    element.classList.add('d-none')
    let classNames = order === 'Asc'? 'sort-desc' : 'remove-sort';
    debugger;
    const elementToShow = element.parentElement.getElementsByClassName(classNames)[0].classList
    elementToShow.remove('d-none')

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

const removeOrderBy = (fieldName, element) => {
    element.classList.add('d-none')
    const elementToShow = element.parentElement.getElementsByClassName('sort-asc')[0].classList
    elementToShow.remove('d-none')


    globalSorting = globalSorting.filter( item => item.name !== fieldName)
    searchPlayerByName();
}

const enableButton = (id) => {
    const wrapper = document.getElementById(id);
    wrapper.classList.remove('disabled')
    let button = wrapper.getElementsByTagName('button')[0]
    button.removeAttribute('tabindex')
    button.removeAttribute('disabled')
    button.removeAttribute('aria-disabled')
}

const disableButton = (id) =>  {
    const wrapper = document.getElementById(id);
    wrapper.classList.add('disabled')
    let button = wrapper.getElementsByTagName('button')[0]
    button.setAttribute('tabindex', '-1')
    button.setAttribute('disabled', 'true')
    button.setAttribute('aria-disabled', 'true')
}

const nextPage = () => {
    currentPage++;
    searchPlayerByName();
    return false;
}

const previousPage = () => {
    currentPage--;
    searchPlayerByName();
    return false;
}

const setApiServerAs = (server) => {
    apiServer = (server === "Elixir") ? "http://localhost:8090": "http://localhost:8080";
    searchPlayerByName();
}

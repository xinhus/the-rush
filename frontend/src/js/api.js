
const retrieveDataFromApi = (apiServer, playerName, sorting, page, recordsPerPage) => {
    let sortingUrl = '';
    sorting.forEach(fieldToSort => {
        sortingUrl += 'order[' + fieldToSort.name + ']=' + fieldToSort.order +'&';
    });
    return fetch(apiServer + "/playersData?page=" + page + "&recordsPerPage=" + recordsPerPage + "&playerName="+ playerName + "&" + sortingUrl)
}

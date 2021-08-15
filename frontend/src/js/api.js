
const retrieveDataFromApi = (playerName, sorting, page, recordsPerPage) => {
    let sortingUrl = '';
    sorting.forEach(fieldToSort => {
        sortingUrl += 'order[' + fieldToSort.name + ']=' + fieldToSort.order +'&';
    });
    return fetch("http://localhost:8080/playersData?page=" + page + "&recordsPerPage=" + recordsPerPage + "&playerName="+ playerName + "&" + sortingUrl)
}

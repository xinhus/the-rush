
const retrieveDataFromApi = (playerName, sorting) => {
    let sortingUrl = '';
    sorting.forEach(fieldToSort => {
        sortingUrl += 'order[' + fieldToSort.name + ']=' + fieldToSort.order +'&';
    });
    return fetch("http://localhost:8080/playersData?playerName="+playerName + "&" + sortingUrl)
        .then(response => {
            document.getElementById("exportButton").href = response.url.replace('playersData', 'playersData/export');
            return response.json()
        })
}

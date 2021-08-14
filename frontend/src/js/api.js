
const retrieveDataFromApi = (playerName) => {
    return fetch("http://localhost:8080/playersData?playerName="+playerName)
        .then(response => {
            const downloadUrl = response.url.replace('playersData', 'playersData/export')
            document.getElementById("exportButton").href = downloadUrl;
            return response.json()
        })
}

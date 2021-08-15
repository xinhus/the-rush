
const setPageAsLoading = () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('searchPlayerByName')).hide();
    let loaderClassList = document.getElementById('loader').classList;
    loaderClassList.remove('invisible')
    loaderClassList.add('visible')
    let containerClassList = document.getElementById('container').classList;
    containerClassList.remove('visible')
    containerClassList.add('invisible')
}

const createRowsForRecordSet = (promise) => {

    const PlayerStruct = [
        "Player",
        "Team",
        "Pos",
        "Att/G",
        "Att",
        "Yds",
        "Avg",
        "Yds/G",
        "TD",
        "Lng",
        "1st",
        "1st%",
        "20+",
        "40+",
        "FUM"
    ]


    const checkPreviousButtonOnPagination = () => {
        if (currentPage > 1) {
            enableButton('previous-button')
        }
        if (currentPage === 1) {
            disableButton('previous-button')
        }
    }

    const checkNextButtonOnPagination = (players) => {
        if ( players.length >= recordsPerPage ) {
            enableButton('next-button')
        } else {
            disableButton('next-button')
        }
    }

    const parseResponseToJson = (response) => response.json();

    const setExportPageLink = (response) => {
        document.getElementById("exportThisPageButton").href = response.url.replace('playersData', 'playersData/export')
        return response;
    }
    const setExportLink = (response) => {
        document.getElementById("exportButton").href = response.url
            .replace('playersData', 'playersData/export')
            .replace('page='+currentPage, 'page=1')
            .replace('recordsPerPage='+recordsPerPage, 'recordsPerPage=100000000000000')
        return response;
    }

    const setPageAsNotLoading = () => {
        let loaderClassList = document.getElementById('loader').classList;
        loaderClassList.remove('visible')
        loaderClassList.add('invisible')
        let containerClassList = document.getElementById('container').classList;
        containerClassList.remove('invisible')
        containerClassList.add('visible')
    }

    const insertPlayersOnHtml= (players) => {
        const table = document.getElementsByTagName('tbody')[0];
        table.innerHTML = '';
        players.forEach(player => {
            let row = table.insertRow();
            for (const propertyPosition in PlayerStruct) {
                let cell = row.insertCell(propertyPosition)
                cell.innerHTML = player[PlayerStruct[propertyPosition]];
            }
        })
        return players
    }

    promise
        .then(setExportPageLink)
        .then(setExportLink)
        .then(parseResponseToJson)
        .then(insertPlayersOnHtml)
        .then(checkNextButtonOnPagination)
        .then(checkPreviousButtonOnPagination)
        .then(setPageAsNotLoading)
}

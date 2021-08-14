
const PlayerStruct = [
    "Player",
    "Team",
    "Pos",
    "Att",
    "Att/G",
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
const setPageAsLoading = () => {
    let loaderClassList = document.getElementById('loader').classList;
    loaderClassList.remove('invisible')
    loaderClassList.add('visible')
    let containerClassList = document.getElementById('container').classList;
    containerClassList.remove('visible')
    containerClassList.add('invisible')
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
}

const createRowsForRecordSet = (promise) => {
    promise
        .then(insertPlayersOnHtml)
        .then(setPageAsNotLoading)
}
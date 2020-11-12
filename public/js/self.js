function logCollapse(){
    let collapsedCard = document.getElementById('logsBlock');
    if (collapsedCard.classList.contains('show')) {
        return collapsedCard.classList.remove('show');
    } else {
        return collapsedCard.classList.add('show');
    }
}

function systemInformationCollapse() {
    let collapsedCard = document.getElementById('sysInfoBlock');
    if (collapsedCard.classList.contains('show')) {
        return collapsedCard.classList.remove('show');
    } else {
        return collapsedCard.classList.add('show');
    }
}

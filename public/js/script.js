
// On vérifie que la page est bien entièrement chargée grâce à cette fonction
document.addEventListener('DOMContentLoaded', (event) => {
    console.log('DOM fully loaded and parsed');
});


// On stock temporairemnt dans la session la variable count_drink pour ne pas qu'elle
// soit remise à niveau lors du rechargement de la page
var count_drink = parseInt(sessionStorage.getItem('count_drink'), 10) || 0;
document.getElementById("myDrinks").innerHTML = count_drink;

// fonction permettant de récupérer le nombre de gorgées totales bues par les joueurs de la partie
function getCountDrink() {
    var postShots = parseInt(document.getElementById("shots").innerText);
    var temp = 0;
    temp += postShots;
    sessionStorage.setItem('count_drink', count_drink += temp);
    console.log(temp, count_drink);
}



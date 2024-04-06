function getComuni(obj="") {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `server/api.php/${obj ? '/' + obj : ''}`);
    xhr.onload = () => {
        if (xhr.status !== 200) {
            console.error('Error while fetching messages');
            return;
        }

        const data = JSON.parse(xhr.response);
        console.log(data);
        const comuni = document.getElementById("cont-data");
        comuni.innerHTML = "";
        data.forEach(element => {
            comuni.innerHTML += `<li>${element.id}; ${element.comune}; ${element.cap}</li>`;
        });
    }

    xhr.send();
}

function addComune() {
    const comune = document.getElementById("comune").value;
    const cap = document.getElementById("cap").value;

    xhr = new XMLHttpRequest();
    xhr.open('POST', 'server/api.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(`comune=${encodeURIComponent(comune)}&cap=${encodeURIComponent(cap)}`);

    xhr.onload = function() {
        if (xhr.status !== 200) {
            console.error('Error while fetching messages');
            return;
        }

        const response = JSON.parse(xhr.response);
        if (response.message == 'Municipality added successfully') {
            getComuni();
        }
    };
}
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
function getComuni(obj="") {
    const xhr = new XMLHttpRequest();
    xhr.open("GET", `server/api/${obj ? '/' + obj : ''}`);
    xhr.onload = () => {
        if (xhr.status !== 200) {
            console.error('Error while fetching messages');
            return;
        }

        const data = JSON.parse(xhr.response);
        // console.log(data);
        const comuni = document.getElementById("cont-data");
        comuni.innerHTML = "";
        data.forEach(element => {
            const li = document.createElement("li");
            li.id = element.id;
            li.style.cursor = "pointer";
            li.style.userSelect = "none";
            li.textContent = `${element.id}; ${element.comune}; ${element.cap}`;
            
            li.addEventListener("click", () => {
                selectElement(element.id, element.cap);
            });
            
            comuni.appendChild(li);
        });

        localStorage.removeItem('selectedElement');
        localStorage.removeItem('selectedElementCAP');
    }

    xhr.send();
}

function addComune() {
    const comune = document.getElementById("comune").value;
    const cap = document.getElementById("cap").value;

    if (!comune || !cap) {
        console.error('Error while adding comune');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "server/api/add");
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = () => {
        if (xhr.status !== 200) {
            console.error('Error while adding comune');
            return;
        }

        getComuni();
    }

    xhr.send(JSON.stringify({comune, cap}));
}

function updateComune() {
    const comune = document.getElementById("modComune").value;
    const cap = localStorage.getItem('selectedElementCAP');

    if (!comune || !cap) {
        console.error('Error while updating comune');
        return;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("PUT", `server/api/update/${cap}`);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = () => {
        if (xhr.status !== 200) {
            console.error('Error while updating comune');
            return;
        }

        getComuni();
    }

    xhr.send(JSON.stringify({comune, cap}));
}

function deleteComune() {
    const cap = localStorage.getItem('selectedElementCAP');

    const xhr = new XMLHttpRequest();
    xhr.open("DELETE", `server/api/delete/${cap}`);
    xhr.onload = () => {
        if (xhr.status !== 200) {
            console.error('Error while deleting comune');
            return;
        }

        getComuni();
    }

    xhr.send();
}

function selectElement(id_elem, cap_elem) {
    const id = id_elem;
    const cap = cap_elem;

    // implement css style for selected element and decolor it if another element is selected or clicked another time
    const selectedElement = document.getElementById(id);
    const previousSelectedElement = document.getElementById(localStorage.getItem('selectedElement'));
    
    if (previousSelectedElement && previousSelectedElement.id === id) {
        selectedElement.style.backgroundColor = "";
        localStorage.removeItem('selectedElement');
        localStorage.removeItem('selectedElementCAP');
        return;
    }

    if (previousSelectedElement) {
        previousSelectedElement.style.backgroundColor = "";
    }
    selectedElement.style.backgroundColor = "yellow";


    localStorage.setItem('selectedElement', id);
    localStorage.setItem('selectedElementCAP', cap);
}
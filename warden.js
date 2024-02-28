var map;
function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: -34.397, lng: 150.644},
        zoom: 8
    });
}
function loadAdvertisements() {
    fetch('https://api.example.com/advertisements')
        .then(response => response.json())
        .then(data => {
            var advertisementsDiv = document.getElementById('advertisements');
            if (data.length === 0) {
                advertisementsDiv.innerHTML = 'No advertisement available for now.';
            } else {
                data.forEach(ad => {
                    var adDiv = document.createElement('div');
                    adDiv.className = 'ad';
                    adDiv.innerHTML = `
                        ${ad.content}
                        <div class="buttons">
                            <button onclick="acceptAd('${ad.id}')">Accept</button>
                            <button onclick="seeDetails('${ad.id}', '${ad.name}', '${ad.price}', '${ad.address}', '${ad.image}', '${ad.availability}')">See Details</button>
                            <button onclick="rejectAd('${ad.id}')">Reject</button>
                        </div>
                    `;
                    advertisementsDiv.appendChild(adDiv);
                });
            }
        })
        .catch(error => {
            var advertisementsDiv = document.getElementById('advertisements');
            advertisementsDiv.innerHTML = 'No advertiesment available for now.';
            console.error('There has been a problem with your fetch operation:', error);
        });
}
function acceptAd(id) {
    // Implement your accept function here
}
function seeDetails(id, name, price, address, image, availability) {
    // Display the modal
    var modal = document.getElementById('myModal');
    modal.style.display = "block";
    // Update the modal content
    var modalContent = document.getElementById('modalContent');
    modalContent.innerHTML = `
        <h2>${name}</h2>
        <img src="${image}" alt="${name}">
        <p>Price: ${price}</p>
        <p>Address: ${address}</p>
        <p>Availability: ${availability}</p>
    `;
}
function rejectAd(id) {
    // Implement your reject function here
}
window.onload = function() {
    loadAdvertisements();
    // Get the modal
    var modal = document.getElementById('myModal');
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
}

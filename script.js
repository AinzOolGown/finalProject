function createPropertyCard(property) {
    const card = document.createElement('div');
    card.className = 'property-card';
    card.innerHTML = `
        <h3>${property.location}</h3>
        <p>Age: ${property.age}</p>
        <p>Floor Plan: ${property.floorPlan}</p>
        <p>Bedrooms: ${property.bedrooms}</p>
        <p>Bathrooms: ${property.bathrooms}</p>
        <p>Garden: ${property.garden ? 'Yes' : 'No'}</p>
        <p>Parking: ${property.parking}</p>
        <p>Proximity: ${property.proximity}</p>
        <p>Main Roads: ${property.mainRoads}</p>
        <p>Property Tax: ${property.propertyTax}</p>
		<img src="${property.imageUrl || 'placeholder.png'}" alt="Property Image" class="property-image">
    `;
	card.addEventListener('click', function() {
        showPropertyDetails(property);
    });
    return card;
}

var modal = document.getElementById("addPropertyForm");
var btn = document.getElementById("addPropertyCard");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "block";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function showPropertyDetails(property) {
    const propertyDetails = document.getElementById('propertyDetails');
    propertyDetails.innerHTML = `
        <img src="${property.image}" alt="${property.location}" class="property-image">
        <h3>${property.location}</h3>
        <p>Age: ${property.age}</p>
        <p>Floor Plan: ${property.floorPlan}</p>
        <p>Bedrooms: ${property.bedrooms}</p>
        <p>Bathrooms: ${property.bathrooms}</p>
        <p>Garden: ${property.garden}</p>
        <p>Parking: ${property.parking}</p>
        <p>Proximity: ${property.proximity}</p>
        <p>Main Roads: ${property.mainRoads}</p>
        <p>Property Tax: ${property.propertyTax}</p>
    `;
    document.getElementById('propertyDetailsModal').style.display = 'block';
}

document.getElementById('closePropertyDetails').addEventListener('click', function() {
    document.getElementById('propertyDetailsModal').style.display = 'none';
});

window.addEventListener('click', function(event) {
    const propertyDetailsModal = document.getElementById('propertyDetailsModal');
    if (event.target == propertyDetailsModal) {
        propertyDetailsModal.style.display = 'none';
    }
});

document.addEventListener('DOMContentLoaded', function() {
    var form = document.getElementById("addPropertyForm");
    if (form) {
        form.onsubmit = function(event) {
            event.preventDefault();
            // Here you would typically gather the form data
            // and send it to the server
            // For now, just close the modal
            modal.style.display = "none";
            console.log("Form submitted!");
            // Add the new property card to the dashboard
        };
    }
});

function createPropertyCard(data) {
    // Create a card element using the data from the server
    let card = document.createElement('div');
    card.className = 'property-card';
    // Populate the card with property data
    // For example:
    card.innerHTML = `
        <h3>${data.location}</h3>
        <p>Age: ${data.age}</p>
        <p>Floor Plan: ${data.floorPlan}</p>
		<p>Bedrooms: ${data.bedrooms}</p>
		<p>Bathrooms: ${data.bathrooms}</p>
		<p>Garden: ${data.garden}</p>
		<p>Parking: ${data.parking}</p>
		<p>Proximity: ${data.proximity}</p>
		<p>Main Roads: ${data.mainRoads}</p>
		<p>Property Tax: ${data.propertyTax}</p>
		<img src="${data.imageUrl || 'placeholder.png'}" alt="Property Image" class="property-image">
    `;
    return card;
}

function populateUpdateForm(propertyId) {
    const propertyData = getPropertyDataById(propertyId);
    // Populate the form fields with the property data
    // ...

    // Show the update property modal
    document.getElementById('updatePropertyModal').style.display = 'block';
}

document.querySelectorAll('.edit-btn').forEach(function(button) {
    button.addEventListener('click', function(event) {
        const propertyId = this.getAttribute('data-property-id');
        populateUpdateForm(propertyId);
        event.stopPropagation(); 
    });
});

// Event listener for the update property form submission
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('addPropertyForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

		fetch('add_property.php', {
			method: 'POST',
			body: formData
		})
		.then(response => response.json())
		.then(data => {
			if (data.success) {
				console.log('good');
				const newPropertyCard = createPropertyCard(data.property);
				document.getElementById('dashboard').appendChild(newPropertyCard);
			} else {
				// Handle error
				console.log('fail');
				console.log(data);
			}
		})
		.catch(error => {
			console.log('fail2');
			console.error('Error:', error);
		});
    });
});

function createPropertyCard(propertyData) {
    // Create the main card element
    let card = document.createElement('div');
    card.className = 'property-card';

    // Populate the card with property data
    card.innerHTML = `
        <img src="${propertyData.imagePath || '\placeholder.png'}" alt="Property Image" class="property-image">
        <div class="property-info">
            <h3>${propertyData.location}</h3>
            <p>Age: ${propertyData.age}</p>
            <p>Floor Plan: ${propertyData.floorPlan}</p>
            <p>Bedrooms: ${propertyData.bedrooms}</p>
            <p>Bathrooms: ${propertyData.bathrooms}</p>
            <p>Garden: ${propertyData.garden ? 'Yes' : 'No'}</p>
            <p>Parking: ${propertyData.parking}</p>
            <p>Proximity: ${propertyData.proximity}</p>
            <p>Main Roads: ${propertyData.mainRoads}</p>
            <p>Property Tax: ${propertyData.propertyTax}</p>
        </div>
    `;

    // Return the completed card
    return card;
}

function fetchProperties() {
    fetch('get_properties.php')
    .then(response => response.json())
    .then(properties => {
        properties.forEach(property => {
            const propertyCard = createPropertyCard(property);
            document.getElementById('dashboard').appendChild(propertyCard);
        });
    })
    .catch(error => console.error('Error:', error));
}

document.addEventListener('DOMContentLoaded', function() {
    fetchProperties();
    // other code...
});

// Function to update the property card
function updatePropertyCard(updatedPropertyData) {
    // Update the DOM elements of the property card with the new data
    // ...
}

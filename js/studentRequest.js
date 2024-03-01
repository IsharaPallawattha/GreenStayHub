document.addEventListener("DOMContentLoaded", function() {
    // Sample data (replace with actual data)
    var studentRequests = [
        { name: "John Doe", address: "123 Main St", telephone: "555-1234", roomType: "Single" },
        { name: "Jane Smith", address: "456 Elm St", telephone: "555-5678", roomType: "Shared" }
    ];

    var tableBody = document.querySelector("#requestsTable tbody");

    // Populate the table with student requests
    studentRequests.forEach(function(student) {
        var row = document.createElement("tr");

        row.innerHTML = `
            <td>${student.name}</td>
            <td>${student.address}</td>
            <td>${student.telephone}</td>
            <td>${student.roomType}</td>
            <td>
                <button onclick="acceptRequest()">Accept</button>
                <button onclick="rejectRequest()">Reject</button>
            </td>
        `;

        tableBody.appendChild(row);
    });

    // Function to handle accepting a request
    window.acceptRequest = function() {
        // Your code to handle accepting a request goes here
        console.log("Request accepted");
    };

    // Function to handle rejecting a request
    window.rejectRequest = function() {
        // Your code to handle rejecting a request goes here
        console.log("Request rejected");
    };
});

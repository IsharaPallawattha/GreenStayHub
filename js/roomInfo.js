document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#roomTable tbody');
    const addRowBtn = document.getElementById('addRowBtn');
    const searchInput = document.getElementById('searchInput');
  
    // Sample data (replace with actual data)
    let rooms = [
      { roomNumber: '101', floor: '1', booked: 'Yes', beds: '2' },
      { roomNumber: '102', floor: '1', booked: 'No', beds: '3' },
      { roomNumber: '201', floor: '2', booked: 'Yes', beds: '1' }
    ];
  
    // Function to render table rows
    function renderRows() {
      tableBody.innerHTML = '';
      rooms.forEach(room => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${room.roomNumber}</td>
          <td>${room.floor}</td>
          <td>${room.booked}</td>
          <td>${room.beds}</td>
          <td>
            <button class="btn btn-sm btn-info edit">Edit</button>
            <button class="btn btn-sm btn-danger delete">Delete</button>
          </td>
        `;
        tableBody.appendChild(row);
      });
    }
  
    // Initial rendering of rows
    renderRows();
  
    // Function to add a new row
    addRowBtn.addEventListener('click', function () {
      rooms.push({ roomNumber: '', floor: '', booked: '', beds: '' });
      renderRows();
    });
  
    // Search functionality
    searchInput.addEventListener('input', function () {
      const searchText = searchInput.value.trim().toLowerCase();
      const filteredRooms = rooms.filter(room => room.roomNumber.toLowerCase().includes(searchText));
      renderRows(filteredRooms);
    });
  
    // Event delegation for edit and delete buttons
    tableBody.addEventListener('click', function (event) {
      if (event.target.classList.contains('edit')) {
        const row = event.target.closest('tr');
        const index = Array.from(row.parentNode.children).indexOf(row);
        const editedRoom = rooms[index]; // Modify this object as per your editing logic
        console.log('Edit:', editedRoom);
        // Implement your edit logic here
      } else if (event.target.classList.contains('delete')) {
        const row = event.target.closest('tr');
        const index = Array.from(row.parentNode.children).indexOf(row);
        rooms.splice(index, 1);
        renderRows();
      }
    });
  });
  
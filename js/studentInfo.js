document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#studentTable tbody');
    const addRowBtn = document.getElementById('addRowBtn');
    const searchInput = document.getElementById('searchInput');
  
    // Sample data (replace with actual data)
    let students = [
      { roomNumber: '101', studentNumber: 'S001', studentName: 'John Doe', homeAddress: '123 Main St', floor: '1', phoneNumber: '123-456-7890', roomType: 'Single' },
      { roomNumber: '102', studentNumber: 'S002', studentName: 'Jane Smith', homeAddress: '456 Elm St', floor: '1', phoneNumber: '456-789-0123', roomType: 'Share' }
    ];
  
    // Function to render table rows
    function renderRows() {
      tableBody.innerHTML = '';
      students.forEach(student => {
        const row = document.createElement('tr');
        row.innerHTML = `
          <td>${student.roomNumber}</td>
          <td>${student.studentNumber}</td>
          <td>${student.studentName}</td>
          <td>${student.homeAddress}</td>
          <td>${student.floor}</td>
          <td>${student.phoneNumber}</td>
          <td>${student.roomType}</td>
          <td>
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
      students.push({ roomNumber: '', studentNumber: '', studentName: '', homeAddress: '', floor: '', phoneNumber: '', roomType: '' });
      renderRows();
    });
  
    // Search functionality
    searchInput.addEventListener('input', function () {
      const searchText = searchInput.value.trim().toLowerCase();
      const filteredStudents = students.filter(student => student.studentNumber.toLowerCase().includes(searchText));
      renderRows(filteredStudents);
    });
  
    // Event delegation for delete buttons
    tableBody.addEventListener('click', function (event) {
      if (event.target.classList.contains('delete')) {
        const row = event.target.closest('tr');
        const index = Array.from(row.parentNode.children).indexOf(row);
        students.splice(index, 1);
        renderRows();
      }
    });
  });
  
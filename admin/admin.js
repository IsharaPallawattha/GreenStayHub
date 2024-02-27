// Show/hide the new account form
const createAccountBtn = document.getElementById('create-account-btn');
const createAccountForm = document.getElementById('create-account-form');

createAccountBtn.addEventListener('click', () => {
  createAccountForm.classList.toggle('hidden');
  createAccountForm.classList.toggle('show');
});

// Handle click on User Management button in side navigation
const userManagementLink = document.querySelector('.sidenav a[href="#user-management"]');

userManagementLink.addEventListener('click', (e) => {
  e.preventDefault();
  createAccountForm.classList.remove('hidden');
  createAccountForm.classList.add('show');
});

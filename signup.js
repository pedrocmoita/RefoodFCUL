/* const psswd_volunteer = document.getElementById('password-volunteer');
const psswd_institution = document.getElementById('password-institution');

const error_volunteer = document.getElementById("error-volunteer");
const error_institution = document.getElementById("error-institution");

const form_volunteer = document.getElementById("form-volunteer");
const form_institution = document.getElementById("form-institution");

form_volunteer.addEventListener('submit', (e) => {
    let messages =[];
    if (psswd_volunteer.value.length <= 4){
        messages.push('Password must be longer than 4 characters')
    }
    if (messages.length > 0){
        e.preventDefault()
        error_volunteer.innerText = messages.join(', ')
    }
}); */
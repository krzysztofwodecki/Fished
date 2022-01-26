const emailInput = document.querySelector('input[name="email"]');
const passwordInput = document.querySelector('input[name="password"]');
const confirmedPassword = document.querySelector('input[name="confirm_password"]');
const actualPassword = document.querySelector('input[name="actual_password"]');

const nameInput = document.querySelector('input[name="name"]');
const surnameInput = document.querySelector('input[name="surname"]');

const phoneNumber = document.querySelector('input[name="phone_number"]')

const button = document.querySelector('button');

console.log(passwordInput);

function isEmpty(text) {
    return /\S/.test(text);
}

function isEmail(email) {
    return /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email)
        && isEmpty(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword && isEmpty(confirmedPassword);
}

confirmedPassword.addEventListener('focusout', function(){
    const condition = arePasswordsSame(
        confirmedPassword.previousElementSibling.value,
        confirmedPassword.value
    );
    markValidation(confirmedPassword, condition);
});

passwordInput.addEventListener('keyup', function(){
    passwordValidate(passwordInput.value);
});

emailInput.addEventListener('focusout', function(){
    markValidation(emailInput, isEmail(emailInput.value));
});

nameInput.addEventListener('focusout', function(){
    markValidation(nameInput, /^[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź]*$/.test(nameInput.value));
});

surnameInput.addEventListener('focusout', function(){
    markValidation(surnameInput,
        /^[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź]*(-[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź])?$/.test(surnameInput.value));
});

phoneNumber.addEventListener('focusout', function(){
    markValidation(phoneNumber, /^([0-9]{9})$/.test(phoneNumber.value));
});

actualPassword.addEventListener('focusout', function(){
    button.disabled = actualPassword.value === "";
})

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
}

function passwordValidate(password) {
    const lowerCaseLetters = /[a-ząćńęśłóżź]/g;
    const upperCaseLetters = /[A-ZĄĆŃĘŚŁÓŻŹ]/g;
    const numbers = /[0-9]/g;

    markValidation(passwordInput, password.match(lowerCaseLetters) && password.match(upperCaseLetters)
                                    && password.match(numbers) && password.length >= 8)
}
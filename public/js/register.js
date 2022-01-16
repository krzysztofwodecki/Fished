const form = document.querySelector("form");
const emailInput = form.querySelector('input[name="email"]');
const passwordInput = form.querySelector('input[name="password"]');
const confirmedPassword = form.querySelector('input[name="confirm_password"]');
const nameInput = form.querySelector('input[name="name"]');
const surnameInput = form.querySelector('input[name="surname"]');
const button = form.querySelector('button');

const div = document.querySelector("div");
const passwordMessage = div.querySelector(".password-validate");

const lowerLetter = document.getElementById("letter");
const upperLetter = document.getElementById("capital");
const passwordNumber = document.getElementById("number");
const passwordLength = document.getElementById("length");


function isEmpty(text) {
    return /\S/.test(text);
}

function isEmail(email) {
    return /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/.test(email) && isEmpty(email);
}

function arePasswordsSame(password, confirmedPassword) {
    return password === confirmedPassword && isEmpty(confirmedPassword);
}

function markValidation(element, condition) {
    !condition ? element.classList.add('no-valid') : element.classList.remove('no-valid');
    !condition ? button.disabled = true : button.disabled = false;
}

emailInput.addEventListener('focusout', function(){
    markValidation(emailInput, isEmail(emailInput.value));
});

passwordInput.addEventListener('mousedown', function(){
    passwordMessage.style.display = "block";
});

passwordInput.addEventListener('focusout', function(){
    passwordMessage.style.display = "none";
    markValidation(passwordInput, isEmpty(passwordInput.value));
});

confirmedPassword.addEventListener('focusout', function(){
    const condition = arePasswordsSame(
        confirmedPassword.previousElementSibling.value,
        confirmedPassword.value
    );
    markValidation(confirmedPassword, condition);
});

nameInput.addEventListener('focusout', function(){
    markValidation(nameInput, /^[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź]+$/.test(nameInput.value));
});

surnameInput.addEventListener('focusout', function(){
    markValidation(surnameInput, /^[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź]+(-[A-ZĄĆŃĘŚŁÓŻŹ][a-ząćńęśłóżź]+)?$/.test(surnameInput.value));
});


passwordInput.addEventListener('keyup', function(){
    passwordValidate(passwordInput.value);
});

function passwordValidate(password) {
    const lowerCaseLetters = /[a-ząćńęśłóżź]/g;
    const upperCaseLetters = /[A-ZĄĆŃĘŚŁÓŻŹ]/g;
    const numbers = /[0-9]/g;

    if(password.match(lowerCaseLetters)) {
        validate(lowerLetter);
    } else {
        invalidate(lowerLetter);
    }

    if(password.match(upperCaseLetters)) {
        validate(upperLetter);
    } else {
        invalidate(upperLetter);
    }

    if(password.match(numbers)) {
        validate(passwordNumber);
    } else {
        invalidate(passwordNumber);
    }

    if(password.length >= 8) {
        validate(passwordLength);
    } else {
        invalidate(passwordLength);
    }
}

function validate(element) {
    element.classList.remove("invalid");
    element.classList.add("valid");

    button.disabled = false
}

function invalidate(element) {
    element.classList.remove("valid");
    element.classList.add("invalid");

    button.disabled = true
}
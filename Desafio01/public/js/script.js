function changeEmailDivState() {
    var checkBox = document.getElementById('sendEmailCheckBox');
    var div = document.getElementById('emailDiv');

    if (checkBox.checked) {
        div.style.display = "block"
    }
    else {
        div.style.display = "none";
    }
}

function checkIfEmailEmpty() {
    var checkBox = document.getElementById('sendEmailCheckBox');
    var emailText = document.getElementById('emailText');
    var cityText = document.getElementById('city');

    if (cityText.value == "") {
        alert("Informe uma cidade");
        event.preventDefault();;
    }
    if (!checkBox.checked) {
        return;
    }
    if (emailText.value != "") {
        return;
    }
    alert("Informe um email");
    event.preventDefault();
}
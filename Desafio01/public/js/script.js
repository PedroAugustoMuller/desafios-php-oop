function changeEmailDivState()
{
    var checkBox = document.getElementById('sendEmailCheckBox');
    var div = document.getElementById('emailDiv');

    if (checkBox.checked)
        {
            div.style.display = "block"
        }
    else
        {
            div.style.display = "none";
        } 
}

function checkIfEmailEmpty()
{
    var checkBox = document.getElementById('sendEmailCheckBox');
    var emailText = document.getElementById('emailText');

    if(!checkBox.checked)
        {
            return;
        }
    if(!emailText.value == "")
        {
            return;
        }
        alert("Informe um email");
        event.preventDefault();
}
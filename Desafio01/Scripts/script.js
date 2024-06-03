function changeEmailDivState()
{
    var checkBox = document.getElementById('sendEmailCheckBox');
    var div = document.getElementById('emailDiv');

    if (checkBox.checked === true)
        {
            div.style.display = "block"
        }
    else
        {
            div.style.display = "none";
        } 
}
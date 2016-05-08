function checkNull($case)
{
    if ($case.textContent == ""){
        $case.setAttribute("style", "background-color: red;");
        console.log($case.textContent);
        return 0;
    }
    return 1;
}
function checkAccount()
{
    
    var $create = document.getElementById("createAccount");
    var $bool
    checkNull(document.getElementById("createLogin"));
    checkNull(document.getElementById("createLastName"));
    checkNull(document.getElementById("createFirstName"));
    checkNull(document.getElementById("createMail"));
    console.log("ca passe");
}
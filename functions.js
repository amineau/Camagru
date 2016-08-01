function checkNull(doc)
{
    if (doc.value == ""){
        doc.setAttribute("style", "border-color: #FF5500;");
        return 0;
    }
    doc.setAttribute("style", "border-color: #C1C1C1;");
    return 1;
}

function validateEmail(email) 
{
    if (/\S+@\S+\.\S+/.test(email.value) == false){
        email.setAttribute("style", "border-color: #FF5500;");
        return 0;
    }
    email.setAttribute("style", "border-color: #C1C1C1;");
    return 1;
}

function minimumPassword(pwd)
{
    if (pwd.value.length < 6 || !pwd.value.match(/[a-zA-Z]/) || !pwd.value.match(/[0-9]/)){
        pwd.setAttribute("style", "border-color: #FF5500;");
        return 0;
    }
    pwd.setAttribute("style", "border-color: #C1C1C1;");
    return 1;
}

function isSame(psw, conf)
{
    if (psw.value != conf.value){
        conf.setAttribute("style", "border-color: #FF5500;");
        return 0;
    }
    conf.setAttribute("style", "border-color: #C1C1C1;");
    return 1;
}

function checkAccount()
{
    var bool = 1;
    if (!checkNull(document.getElementById("createLogin")))
        bool = 0;
    if (!validateEmail(document.getElementById("createMail")))
        bool = 0;
    if (!minimumPassword(document.getElementById("createPasswd")))
        bool = 0;
    if (!bool || !isSame(document.getElementById("createPasswd"), document.getElementById("createConfPasswd")))
        return 0;
    document.getElementById('createAccount').submit();
}

function checkUpdate()
{
    var bool = 1;
     if (!minimumPassword(document.getElementById("new_passwd")))
        bool = 0;
    if (!bool || !isSame(document.getElementById("new_passwd"), document.getElementById("conf_passwd")))
        return 0;
    document.getElementById("updateAccount").submit();
}

function fsubmit() {
    document.forms['like'].coeur.value = this.id;
    document.forms['like'].submit();
}

function getXMLHttpRequest() {
    var xhr = null;
    
    if (window.XMLHttpRequest || window.ActiveXObject) {
        if (window.ActiveXObject) {
            try {
                xhr = new ActiveXObject("Msxml2.XMLHTTP");
            } catch(e) {
                xhr = new ActiveXObject("Microsoft.XMLHTTP");
            }
        } else {
            xhr = new XMLHttpRequest(); 
        }
    } else {
        alert("Votre navigateur ne supporte pas l'objet XMLHTTPRequest...");
        return null;
    }
    
    return xhr;
}
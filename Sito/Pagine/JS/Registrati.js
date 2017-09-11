function controllaForm(){
    var controllo = true;
    var errors = "";

    if(document.getElementById("username").value == "" || document.getElementById("nome").value == "" || document.getElementById("cognome").value == "" ||
        document.getElementById("email2").value == "" || document.getElementById("password2").value == "" || document.getElementById("città").value == "" ||
        document.getElementById("civico").value == "" || document.getElementById("via").value == "" || document.getElementById("cap").value == ""){

        controllo = false;
        errors = "<li class='errore'>Attenzione: Compilare tutti i campi </li>";
    }
    else{

        var username = document.getElementById("username").value;
        var nome = document.getElementById("nome").value;
        var cognome = document.getElementById("cognome").value;
        var email = document.getElementById("email2").value;
        var password = document.getElementById("password2").value;
        var citta = document.getElementById("città").value;
        var via = document.getElementById("via").value;
        var civico = document.getElementById("civico").value;
        var cap = document.getElementById("cap").value;


        if(!(/^([À-ÿ_\w]){4,16}$/.test(username))){
            controllo = false;
            errors = errors + "<li class='errore'><span lang='en'>Username</span> non inserito correttamente</li>";
        }

        if(!(/^([À-ÿ_\w\s]){1,30}$/.test(nome))){
            controllo = false;
            errors = errors + "<li class='errore'>Nome non inserito correttamente</li>";
        }

        if(!(/^([À-ÿ_\w\s]){1,30}$/.test(cognome))){
            controllo = false;
            errors = errors + "<li class='errore'>Cognome non inserito correttamente</li>";
        }

        if(!(/^([À-ÿ_\w+.]+)@([\w+.]+)\.([\w+.]+){1,255}$/.test(email))){
            controllo = false;
            errors = errors + "<li class='errore'><span lang='en'>Email</span> non inserita correttamente</li>";
        }

        if(!(/^([À-ÿ_\w]){4,12}$/.test(password))){
            controllo = false;
            errors = errors + "<li class='errore'><span lang='en'>Password</span> non inserita correttamente</li>";
        }


        if(!(/^([À-ÿ_\w\s]){1,50}$/.test(citta))){
            controllo = false;
            errors = errors + "<li class='errore'>Città non inserita correttamente</li>";
        }

        if(!(/^([À-ÿ_\w\s]){1,50}$/.test(via))){
            controllo = false;
            errors = errors + "<li class='errore'>Via non inserita correttamente</li>";
        }

        if(!(/^([\/_\w]){1,10}$/.test(civico))){
            controllo = false;
            errors = errors + "<li class='errore'>Civico non inserito correttamente</li>";
        }

        if (!(/^([\d]){1,8}$/.test(cap))){
            controllo = false;
            errors = errors + "<li class='errore'>Cap non inserito correttamente</li>";
        }

    }

    if(errors != ""){

        if(document.getElementById("errori")==null){
            var main = document.getElementById("form1");
            var err = document.createElement("ul");
            var attr = document.createAttribute("id");
            err.innerHTML = errors;
            attr.value = "errori";
            err.setAttributeNode(attr);
            main.parentNode.insertBefore(err, main);
        }
        else{
            document.getElementById("errori").innerHTML = errors;
        }

    }

    return controllo;
}
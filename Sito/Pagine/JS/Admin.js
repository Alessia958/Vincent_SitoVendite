function controllaForm(){
    var controllo = true;
    var errors = "";

    var nome = document.getElementById("Nomep").value;
    var descrizione = document.getElementById("Descrizionep").value;
    var prezzo = document.getElementById("prezzop").value;

    if (nome == "" ||  descrizione == "" || prezzo == ""
        || document.getElementById("picture").value == ""){

        controllo = false;
        errors = "<li class='errore'>Attenzione: Compilare tutti i campi </li>";
    }
    else{
        if(!(/^([[À-ÿ_\w\s]){1,30}$/.test(nome))){
            controllo = false;
            errors = errors + "<li class='errore'>Nome non inserito correttamente</li>";
        }

        if(!(/^([[À-ÿ_\w\s]){1,200}$/.test(descrizione))){
            controllo = false;
            errors = errors + "<li class='errore'>Descrizione non inserita correttamente</li>";
        }

        if(!(/^[0-9]{1,9}(\.[0-9]{1,2})?$/.test(prezzo))){
            controllo = false;
            errors = errors + "<li class='errore'>Prezzo non inserito correttamente</li>";
        }
    }

    if(errors != ""){

        if(document.getElementById("errori")==null){
            var main = document.getElementById("form2");
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
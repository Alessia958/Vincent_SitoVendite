function show(){
    var menu = document.getElementById("myDropdown");
    var arrow = document.getElementById("arrow");

    if (menu.className){
        menu.className = "";
        arrow.innerHTML = "Prodotti &#9650;";
    }
    else{
        var att = document.createAttribute("class");
        att.value = "hide";
        menu.setAttributeNode(att);

        arrow.innerHTML = "Prodotti &#9660;";
    }

}

function hide(){
    var li = document.getElementById("dropbtn");
    var attrib = document.createAttribute("class");
    attrib.value = "cursor";
    li.setAttributeNode(attrib);

    var menu = document.getElementById("myDropdown");
    var att = document.createAttribute("class");
    att.value = "hide";
    menu.setAttributeNode(att);

    var arrow = document.getElementById("arrow");
    arrow.innerHTML = "Prodotti &#9660;";
}


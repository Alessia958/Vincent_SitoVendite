function plusSlides(n){
    showSlides(slideIndex += n);
}

function showSlides(n){
    var i,j;
    var slides = document.getElementsByClassName("Slides");
    var bprec = document.getElementsByClassName("prec");
    var bsucc = document.getElementsByClassName("succ");

    if(n > slides.length){
        slideIndex = 1;
    }

    if(n < 1){
        slideIndex = slides.length;
    }

    for (i = 0; i < slides.length ; i++){
        slides[i].style.display = "none";
    }

    for(j = 0; j < bprec.length; j++){
        bprec[j].style.display="block";
        bsucc[j].style.display="block";
    }

    if(slides[slideIndex-1] !== undefined){
        slides[slideIndex-1].style.display = "block";
    }

}

var Index = 1;
window.onload = showSlides(Index);


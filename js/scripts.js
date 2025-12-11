function myFunction(y) {
    var x = document.getElementById("menu-list");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
    y.classList.toggle("change");
}

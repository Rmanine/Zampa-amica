function myFunction(y) {
    var x = document.getElementById("menu-list");
    if (x.style.display === "block") {
        x.style.display = "none";
    } else {
        x.style.display = "block";
    }
    y.classList.toggle("change");
}

document.addEventListener("DOMContentLoaded", function() {

    const params = new URLSearchParams(window.location.search);

    params.forEach((value, key) => {
        const input = document.querySelector(`input[name="${key}"][value="${value}"]`);
        if (input) {
            input.checked = true;
        }
    });
});

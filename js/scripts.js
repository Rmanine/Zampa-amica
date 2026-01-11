function myFunction(button) {
    const nav = document.getElementById("menu");
    const isOpen = button.getAttribute("aria-expanded") === "true";

    nav.classList.toggle("open");
    button.classList.toggle("change");

    button.setAttribute("aria-expanded", String(!isOpen));

    button.setAttribute(
        "aria-label",
        isOpen ? "Apri menu di navigazione" : "Chiudi menu di navigazione"
    );
}
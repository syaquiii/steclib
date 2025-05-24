document.addEventListener("DOMContentLoaded", () => {
    const navbar = document.getElementById("navbar");

    if (!navbar) return;

    window.addEventListener("scroll", () => {
        if (window.scrollY > 10) {
            navbar.classList.add("bg-brown-custom", "shadow-md");
        } else {
            navbar.classList.remove("bg-brown-custom", "shadow-md");
        }
    });
});

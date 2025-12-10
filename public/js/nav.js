window.addEventListener("scroll", function () {
    const nav = document.querySelector(".glass-nav");
    const features = document.getElementById("features");

    // Get the Y position of the section
    const featuresTop = features.offsetTop;

    if (window.scrollY >= featuresTop - 100) {
        nav.classList.add("scrolled");
    } else {
        nav.classList.remove("scrolled");
    }
});

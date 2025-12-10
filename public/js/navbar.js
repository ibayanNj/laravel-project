// Mobile Menu Toggle
document.addEventListener("DOMContentLoaded", function () {
    const mobileMenuButton = document.getElementById("mobile-menu-button");
    const mobileMenu = document.getElementById("mobile-menu");
    const menuOpenIcon = document.getElementById("menu-open-icon");
    const menuCloseIcon = document.getElementById("menu-close-icon");

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener("click", function () {
            // Toggle menu visibility
            mobileMenu.classList.toggle("hidden");

            // Toggle icons
            menuOpenIcon.classList.toggle("hidden");
            menuCloseIcon.classList.toggle("hidden");
        });

        // Close menu when clicking outside
        document.addEventListener("click", function (event) {
            const isClickInsideMenu = mobileMenu.contains(event.target);
            const isClickOnButton = mobileMenuButton.contains(event.target);

            if (
                !isClickInsideMenu &&
                !isClickOnButton &&
                !mobileMenu.classList.contains("hidden")
            ) {
                mobileMenu.classList.add("hidden");
                menuOpenIcon.classList.remove("hidden");
                menuCloseIcon.classList.add("hidden");
            }
        });
    }
});

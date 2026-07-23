document.addEventListener("DOMContentLoaded", function () {
    const burgers = document.querySelectorAll(".icon-burger");
    const drawer = document.querySelector(".tablet-drawer");
    const overlay = document.querySelector(".drawer-overlay");
    const closeBtn = document.querySelector(".drawer-close");

    if (!drawer || !overlay) return;

    const openDrawer = () => {
        drawer.classList.add("active");
        overlay.classList.add("active");
        document.body.classList.add("no-scroll");
    };

    const closeDrawer = () => {
        drawer.classList.remove("active");
        overlay.classList.remove("active");
        document.body.classList.remove("no-scroll");
    };

    const toggleDrawer = () => {
        if (drawer.classList.contains("active")) {
            closeDrawer();
        } else {
            openDrawer();
        }
    };

    // відкриття меню 
    burgers.forEach((burger) => {
        burger.addEventListener("click", toggleDrawer);
    });

    // закриття по хрестику
    if (closeBtn) {
        closeBtn.addEventListener("click", closeDrawer);
    }

    // закриття по overlay
    overlay.addEventListener("click", closeDrawer);

    // закриття по ESC
    document.addEventListener("keydown", (e) => {
        if (e.key === "Escape") {
            closeDrawer();
        }
    });
});
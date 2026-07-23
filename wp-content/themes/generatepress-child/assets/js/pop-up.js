document.addEventListener("DOMContentLoaded", function () {

    document.querySelectorAll(".login-required-add-to-cart").forEach(function (button) {

        button.addEventListener("click", function (e) {

            if (medicineCart.isLoggedIn) {
                return;
            }

            e.preventDefault();

            localStorage.setItem(
                "medicine_product",
                this.dataset.productId
            );

            PUM.open(medicineCart.loginPopup);

        });

    });

});
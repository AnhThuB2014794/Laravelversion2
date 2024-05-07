document.addEventListener("DOMContentLoaded", function () {
    const minusButton = document.querySelector(".btn-minus");
    const plusButton = document.querySelector(".btn-plus");
    const addToCartButton = document.querySelector("#addToCartButton");
    const quantityInput = document.querySelector("#quantityInput");

    minusButton.addEventListener("click", function (event) {
        event.stopPropagation();
        let currentValue = parseInt(quantityInput.value, 10);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        } else {
            alert("Số lượng không thể nhỏ hơn 1");
        }
    });

    plusButton.addEventListener("click", function (event) {
        event.stopPropagation();
        let currentValue = parseInt(quantityInput.value, 10);
        quantityInput.value = currentValue + 1;
    });

    addToCartButton.addEventListener("click", function () {
        let quantity = parseInt(quantityInput.value, 10);
        if (quantity < 1) {
            alert("Số lượng phải lớn hơn 0");
            return;
        }
        // Lưu số lượng vào giỏ hàng
        // Giả sử bạn có một API để gọi
        console.log("Thêm vào giỏ hàng với số lượng:", quantity);
        // Thêm code để gọi API thêm vào giỏ hàng ở đây
    });
});

function confirmDelete() {
    return new Promise((resolve, reject) => {
        Swal.fire({
            title: "Bạn có chắc chắn muốn xóa?",
            text: "Sẽ không thể khôi phục sau khi thực hiện chức năng này!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Chắc chắn, hãy xóa chúng!",
            cancelButtonText: "Hủy",
        }).then((result) => {
            if (result.isConfirmed) {
                resolve(true);
            } else {
                reject(false);
            }
        });
    });
}
$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});
$(() => {
    $(document).on("click", ".btn-delete", function (e) {
        e.preventDefault();
        let id = $(this).data("id");
        confirmDelete()
            .then(function () {
                $(`#form-delete${id}`).submit();
            })
            .catch();
    });
});

$(document).ready(function () {
    $(document).on("click", ".modal-link", function (e) {
        openLinkInModal($(this))
        e.preventDefault();
    });
    checkMsg();
})

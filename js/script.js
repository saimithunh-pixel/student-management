
document.addEventListener("DOMContentLoaded", function () {

    // Confirm before deleting a student
    const deleteForms = document.querySelectorAll(".delete-form");

    deleteForms.forEach(function (form) {

        form.addEventListener("submit", function (event) {

            const confirmDelete = confirm(
                "Are you sure you want to delete this student?"
            );

            if (!confirmDelete) {
                event.preventDefault();
            }

        });

    });

});

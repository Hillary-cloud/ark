$(document).ready(function() {
    // Show modal with large image when other image is clicked
    $(".other-image").click(function() {
        var imageUrl = $(this).attr("src");
        $(".modal-image").attr("src", imageUrl);
        $(".modal").fadeIn();
    });

    // Hide modal when clicked outside the image
    $(".modal").click(function() {
        $(this).fadeOut();
    });
});
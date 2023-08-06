
const schoolSelect = document.getElementById('school');
const schoolAreaSelect = document.getElementById('school_area');
const lodgeSelect = document.getElementById('lodge');
const slugField = document.getElementById('slug');

// Function to generate slug which is coming from lodge
function generateSlug() {
    const lodgeName = lodgeSelect.options[lodgeSelect.selectedIndex].textContent;
    const slug = lodgeName.toLowerCase().replace(/\s+/g, '-');
    slugField.value = slug;
}

// Function to fetch schools based on the selected location
function fetchSchools(locationId) {
    fetch(`/post-ad/schools/${locationId}`)
        .then(response => response.json())
        .then(data => {
            schoolSelect.innerHTML = '<option value="">Select School</option>';
            schoolAreaSelect.innerHTML = '<option value="">Select School Area</option>';

            if (data.length > 0) {
                data.forEach(school => {
                    const option = document.createElement('option');
                    option.value = school.id;
                    option.textContent = school.name;
                    schoolSelect.appendChild(option);
                });

                schoolSelect.removeAttribute('disabled');
            } else {
                schoolSelect.setAttribute('disabled', true);
            }
        })
        .catch(error => console.error(error));
}

// Function to fetch school areas based on the selected school
function fetchSchoolAreas(schoolId) {
    fetch(`/post-ad/school-areas/${schoolId}`)
        .then(response => response.json())
        .then(data => {
            schoolAreaSelect.innerHTML = '<option value="">Select School Area</option>';

            if (data.length > 0) {
                data.forEach(area => {
                    const option = document.createElement('option');
                    option.value = area.id;
                    option.textContent = area.name;
                    schoolAreaSelect.appendChild(option);
                });

                schoolAreaSelect.removeAttribute('disabled');
            } else {
                schoolAreaSelect.setAttribute('disabled', true);
            }
        })
        .catch(error => console.error(error));
}

// Event listeners to fetch schools and school areas
document.getElementById('location').addEventListener('change', function() {
    const locationId = this.value;
    if (locationId) {
        fetchSchools(locationId);
    } else {
        schoolSelect.innerHTML = '<option value="">Select School</option>';
        schoolAreaSelect.innerHTML = '<option value="">Select School Area</option>';
        schoolSelect.setAttribute('disabled', true);
        schoolAreaSelect.setAttribute('disabled', true);
    }
});

document.getElementById('school').addEventListener('change', function() {
    const schoolId = this.value;
    if (schoolId) {
        fetchSchoolAreas(schoolId);
    } else {
        schoolAreaSelect.innerHTML = '<option value="">Select School Area</option>';
        schoolAreaSelect.setAttribute('disabled', true);
    }
});


$(document).ready(function() {
    // Counter to generate unique IDs for image previews
    var imageCounter = 0;
    var otherImagesArray = []; // Array to store selected other images

    // Function to preview the selected cover image
    function previewCoverImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $("#coverImagePreview").html('<img src="' + e.target.result +
                    '" width="150" height="100"/>');
            };
            reader.readAsDataURL(input.files[0]);
        }
    };

    // Function to preview the selected other images
    function previewOtherImages(input) {
        var files = input.files;
        for (var i = 0; i < files.length; i++) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var previewId = "preview_" + imageCounter;
                otherImagesArray.push(e.target.result); // Add image data URL to the array
                $("#otherImagesPreview").append('<div id="' + previewId + '"><img src="' + e.target
                    .result +
                    '" width="100" height="100" /><br><button type="button" class="deleteBtn btn-danger text-light btn-sm rounded-sm mt-1" data-preview="' +
                    previewId + '">Delete</button></div>');
                imageCounter++;
            };
            reader.readAsDataURL(files[i]);
        }
    };

    // Preview the selected cover image
    $("#cover_image").on("change", function() {
        previewCoverImage(this);
    });

    // Preview the selected other images
    $("#other_images").on("change", function() {
        previewOtherImages(this);
    });

    // Handle image deletion
    $(document).on("click", ".deleteBtn", function() {
        var previewDiv = $(this).data("preview");
        $("#" + previewDiv).remove();
        if (previewDiv === "coverImagePreview") {
            $("#cover_image").val(""); // Reset the cover image input
        } else {
            var index = $(this).closest("div").index();
            otherImagesArray.splice(index, 1); // Remove the image data URL from the array
        }
    });

    // Function to update the hidden input for other_images with the selected images
    $("#postAdForm").submit(function() {
        var otherImagesInput = $("#other_images");
        var otherImages = otherImagesArray.map(function(imageDataUrl) {
            return dataURLtoFile(imageDataUrl, "image_" + imageCounter + ".png");
        });
        if (otherImages.length > 4) {
            otherImages.splice(4); // Limit to a maximum of 4 images
        }
        otherImagesInput.prop("files", otherImages);
    });

    // Function to convert Data URL to File object
    function dataURLtoFile(dataURL, fileName) {
        var arr = dataURL.split(","),
            mime = arr[0].match(/:(.*?);/)[1],
            bstr = atob(arr[1]),
            n = bstr.length,
            u8arr = new Uint8Array(n);
        while (n--) {
            u8arr[n] = bstr.charCodeAt(n);
        }
        return new File([u8arr], fileName, {
            type: mime
        });
    }
});

// Additional Function to remove the old cover image when selecting a new one
$("#cover_image").on("click", function() {
    // Remove the old cover image preview
    $("#coverImagePreview").html("");
});





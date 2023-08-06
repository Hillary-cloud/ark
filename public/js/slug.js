        // Define the slugify function
        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .replace(/\s+/g, '-')         // Replace spaces with -
                .replace(/[^\w\-]+/g, '')     // Remove all non-word chars
                .replace(/\-\-+/g, '-')       // Replace multiple - with single -
                .replace(/^-+/, '')           // Trim - from start of text
                .replace(/-+$/, '');          // Trim - from end of text
        }

        // Now you can use the slugify function here
        const stateInput = document.getElementById('name');
        const slugInput = document.getElementById('slug');

        stateInput.addEventListener('input', function() {
            slugInput.value = slugify(stateInput.value);
        });
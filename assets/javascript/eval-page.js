document.addEventListener('DOMContentLoaded', function () {
    // Add event listeners to each checkbox
        document.querySelectorAll('#skillsForm input[type="checkbox"]').forEach(function (checkbox) {
            checkbox.addEventListener('change', function () {
                // Replace the hyphen in the checkbox ID to match the column class format
                const skillClass = '.td-' + this.id.replace('-', '');
                
                document.querySelectorAll(skillClass).forEach(function (td) {
                    if (checkbox.checked) {
                        td.classList.remove('d-none');
                    } else {
                        td.classList.add('d-none');
                    }
                });
            });
        });
    });
$(document).ready(function() {
    // Function to sort table
    function sortTable(table, column, order) {
        var rows = table.find('tbody > tr').get();

        rows.sort(function(a, b) {
            var A = $(a).children('td').eq(column).text().toUpperCase();
            var B = $(b).children('td').eq(column).text().toUpperCase();

            if (order === 'asc') {
                return A.localeCompare(B);
            } else {
                return B.localeCompare(A);
            }
        });

        $.each(rows, function(index, row) {
            table.children('tbody').append(row);
        });
    }

    // Handling click on column headers for sorting
    $('th.sortable').click(function() {
        var table = $(this).closest('table');
        var columnIndex = $(this).index();
        var sortOrder = $(this).hasClass('asc') ? 'desc' : 'asc';

        // Remove sorting classes from all columns
        table.find('th.sortable').removeClass('asc desc');

        // Add sorting class to clicked column
        $(this).addClass(sortOrder);

        // Sort the table
        sortTable(table, columnIndex, sortOrder);
    });

    $('.comment-logo').click(function() {
        $(this).siblings('.comment-form').toggle();
        $(this).closest('tr').find('.success-message').text('');
    });

    $('.commentForm').submit(function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var currentForm = $(this);
        $.ajax({
            type: 'POST',
            url: 'intervenant.php',
            data: formData,
            success: function(response) {
                currentForm.closest('td').find('.success-message').text('Comment sent successfully!').css('color', 'green');
                currentForm.closest('.comment-form').hide();
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Handling click on "Modifier Statut"
    $(document).on('click', '.edit-status', function(event) {
        event.preventDefault();

        // Hide all other status forms except the one clicked
        $('.status-form').not($(this).closest('tr').find('.status-form')).hide();

        // Toggle the status form of the clicked intervention
        $(this).closest('tr').find('.status-form').toggle();
    });

    $(document).on('submit', '.status-form form', function(event) {
        event.preventDefault();
        var formData = $(this).serialize();
        var currentForm = $(this);
        $.ajax({
            type: 'POST',
            url: 'intervenant.php',
            data: formData,
            success: function(response) {
                console.log('Status updated successfully!');

                $('.status-form').hide();

                var newStatusId = currentForm.find('select[name="status"]').val();
                var newStatusText = currentForm.find('select[name="status"] option:selected').text();
                currentForm.closest('tr').find('.status-type').text(newStatusText);

                // Check if the new status is "Closed" or "Cancelled"
                if (newStatusText.toLowerCase() === "cloturer" || newStatusText.toLowerCase() === "annuler") {
                    // Move the intervention to the second table
                    var row = currentForm.closest('tr').detach();
                    $('#table-interventions-passees tbody').append(row);

                    // Scroll the page to the table of closed or cancelled interventions
                    var tableOffset = $('#table-interventions-passees').offset().top;
                    $('html, body').animate({
                        scrollTop: tableOffset
                    }, 500);
                }
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });

    // Handling degree change
    $(document).on('change', '.degree-select', function() {
        var degreeId = $(this).val();
        var imgSrc = '';
        $(this).closest('tr').find('.degree-img').attr('src', imgSrc);
    });

    // Handling click on "Modifier Degré d'urgence"
    $(document).on('click', '.edit-degree', function(event) {
        event.preventDefault();

        // Hide all other degree forms except the one clicked
        $('.degree-form').not($(this).siblings('.degree-form')).hide();

        // Toggle the degree form of the clicked intervention
        $(this).siblings('.degree-form').toggle();
    });
});

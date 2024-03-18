    $(document).ready(function() {

        
        // Fonction pour trier le tableau
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

        // Gestion du clic sur les en-têtes de colonnes pour le tri
        $('th.sortable').click(function() {
            var table = $(this).closest('table');
            var columnIndex = $(this).index();
            var sortOrder = $(this).hasClass('asc') ? 'desc' : 'asc';

            // Supprimer les classes de tri de toutes les colonnes
            table.find('th.sortable').removeClass('asc desc');

            // Ajouter la classe de tri à la colonne cliquée
            $(this).addClass(sortOrder);

            // Trier le tableau
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

        // Gestion du clic sur "Modifier Statut"
        $(document).on('click', '.edit-status', function(event) {
            event.preventDefault();

            // Masquer tous les autres formulaires de statut sauf celui cliqué
            $('.status-form').not($(this).closest('tr').find('.status-form')).hide();

            // Afficher/masquer le formulaire de statut de l'intervention cliquée
            $(this).closest('tr').find('.status-form').toggle();
        });

        // Soumission du formulaire de statut
    // Soumission du formulaire de statut
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

                // Masquer tous les formulaires de statut
                $('.status-form').hide();

                // Mettre à jour dynamiquement le statut de l'intervention
                var newStatusText = currentForm.find('select[name="status"] option:selected').text();
                currentForm.closest('tr').find('.status-type').text(newStatusText);

                // Recharger la page après la mise à jour du statut
                location.reload();

                // Afficher un message de succès ou effectuer d'autres actions nécessaires
                alert('Statut mis à jour avec succès !');
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
                // Gérer les erreurs si nécessaire
            }
        });
    });

        // Gestion du changement de degré
        $(document).on('change', '.degree-select', function() {
            var degreeId = $(this).val();
            var imgSrc = '';
            $(this).closest('tr').find('.degree-img').attr('src', imgSrc);
        });

        // Gestion du clic sur "Modifier Degré d'urgence"
        $(document).on('click', '.edit-degree', function(event) {
            event.preventDefault();

            // Masquer tous les autres formulaires de degré sauf celui cliqué
            $('.degree-form').not($(this).siblings('.degree-form')).hide();

            // Afficher/masquer le formulaire de degré de l'intervention cliquée
            $(this).siblings('.degree-form').toggle();
        });
    });

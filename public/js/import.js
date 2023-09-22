window.addEventListener('load', () => {

    document.querySelectorAll('.collection-item-delete').forEach((item) => {

        item.addEventListener('click', (event) => {

            if (!confirm('Voulez-vous vraiment supprimer ce jeux de données ?')){
                event.preventDefault();
            }

            return false;
        });

    });
});

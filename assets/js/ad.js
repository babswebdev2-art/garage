
    // On récupère le bouton d'ajout
    const addImage = document.querySelector('#add-image');

    if (addImage) {
    addImage.addEventListener('click', () => {
        // On récupère le numéro des futurs champs (index)
        const widgetCounter = document.querySelector('#widgets-counter');
        const index = +widgetCounter.value;

        // On récupère le prototype des entrées (le HTML de ImageType)
        const annonceImages = document.querySelector('#ad_images');
        const prototype = annonceImages.dataset.prototype.replace(/__name__/g, index);

        // On injecte ce code dans la div
        annonceImages.insertAdjacentHTML('beforeend', prototype);

        widgetCounter.value = index + 1;

        // Gestion du bouton supprimer
        handleDeleteButtons();
    });
}

    function handleDeleteButtons() {
    document.querySelectorAll('button[data-action="delete"]').forEach(button => {
        button.addEventListener('click', () => {
            const target = button.dataset.target;
            document.querySelector(target).remove();
        });
    });
}

    handleDeleteButtons();

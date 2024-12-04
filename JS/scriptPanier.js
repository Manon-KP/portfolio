document.querySelectorAll("input[type='number']").forEach(input => {
    input.addEventListener('change', function() {
        const articleId = this.dataset.articleId;
        const newQuantity = parseInt(this.value, 10);

        if (newQuantity < 0) {
            alert('La quantité ne peut pas être négative.');
            return;
        }

        var formData = new FormData();
        formData.append('articleId', articleId);
        formData.append('newQuantity', newQuantity);

        fetch('majQuantitePanier.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log("Mise à jour effectuée.");
                location.reload(); // Recharge la page pour mettre à jour l'affichage
            } else {
                alert(data.message);
                location.reload();
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            alert('Une erreur est survenue lors de la mise à jour de la quantité.');
        });
    });
});

function viderPanier() {
    fetch(window.location.href, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'action=vider_panier'
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        location.reload();
    })
    .catch(error => console.error('Erreur lors du vidage du panier :', error));
}

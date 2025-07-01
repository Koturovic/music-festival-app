document.querySelectorAll('.ukloni-btn1').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Da li ste sigurni da želite da uklonite ovaj događaj?')) return;
            const row = this.closest('tr');
            const dogadjaj_id = this.getAttribute('data-dogadjaj-id');
            fetch('Backend/ukloni_dogadjaj.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'dogadjaj_id=' + encodeURIComponent(dogadjaj_id)
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'Uspesno obrisano') {
                    row.remove();
                } else {
                    alert('Greška pri brisanju!');
                }
            });
        });
    });

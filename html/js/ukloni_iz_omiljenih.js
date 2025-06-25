document.querySelectorAll('.ukloni-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            if (!confirm('Da li ste sigurni da želite da uklonite ovog izvođača iz omiljenih?')) return;
            const izvodjac = this.getAttribute('data-izvodjac');
            const row = this.closest('tr');
            fetch('ukloni_omiljeni.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'izvodjac=' + encodeURIComponent(izvodjac)
            })
            .then(response => response.text())
            .then(data => {
                row.remove();
            });
        });
    });
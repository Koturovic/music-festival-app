


document.addEventListener('DOMContentLoaded', function(){
    var dugme = document.getElementById('Dodaj-u-omiljene');
    if(dugme){
        dugme.addEventListener('click', function(){
            var izvodjac = dugme.getAttribute('data-izvodjac');
            if(!izvodjac){
                alert("Nema imena izvodjaca");
                return;
            }
            fetch('../Backend/dodaj_omiljeni.php',{
                method:'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'izvodjac=' + encodeURIComponent(izvodjac)
            })
            .then(response => response.text())
            .then(data => alert(data));

        });
    }
});
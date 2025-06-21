document.querySelector("form").addEventListener("submit", function(e) {
    const name = document.getElementById('name').value.trim();
    const password = document.getElementById('password').value.trim();

    let errorMsg = "";

    if (name.length < 2) {
        errorMsg = "Korisničko ime mora imati barem 2 slova.";
    } else if (password.length < 6) {
        errorMsg = "Lozinka mora imati najmanje 6 karaktera.";
    }

    if (errorMsg !== "") {
        e.preventDefault(); // Sprečava slanje forme
        alert(errorMsg);    // Prikazuje grešku korisniku
    }
});

document.querySelector("form").addEventListener("submit", function(e) {



    const name = document.getElementById('name').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    let errorMsg = "";

    if (name.length < 2) {
        errorMsg = "Ime mora imati barem 2 slova.";
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        errorMsg = "Neispravan email format.";
    } else if (password.length < 6) {
        errorMsg = "Lozinka mora imati najmanje 6 karaktera.";
    }

    if (errorMsg !== "") {
        e.preventDefault(); 
        alert(errorMsg);    
    }
});

-- Tabela za komentare
CREATE TABLE IF NOT EXISTS komentari (
    id INT AUTO_INCREMENT PRIMARY KEY,
    izvodjac VARCHAR(100) NOT NULL,
    korisnik VARCHAR(100) NOT NULL,
    komentar TEXT NOT NULL
);

-- Tabela za ocene
CREATE TABLE IF NOT EXISTS ocene (
    id INT AUTO_INCREMENT PRIMARY KEY,
    izvodjac VARCHAR(100) NOT NULL,
    korisnik VARCHAR(100) NOT NULL,
    ocena INT NOT NULL
); 
-- Kreiranje tabele dogadjaji
CREATE TABLE IF NOT EXISTS dogadjaji (
    id INT AUTO_INCREMENT PRIMARY KEY,
    izvodjac VARCHAR(100),
    datum DATE NOT NULL,
    scena VARCHAR(100),
    zanr VARCHAR(50)
);

-- Ubacivanje podataka
INSERT INTO dogadjaji (izvodjac, scena, zanr, datum) VALUES
('Aca Lukas','Glavna scena', 'Turbo-folk', '2025-03-21'),
('Aco Pejovic','Glavna scena', 'Pop-folk', '2025-03-22'),
('Dragana Mirkovic','Mala scena', 'Folk', '2025-03-23'),
('Sasa Matic','Glavna scena', 'Pop', '2025-03-25'),
('Milica Pavlovic','Treca scena', 'Urbani-pop', '2025-03-26'),
('Marija Serifovic','Cetvrta scena', 'Zabavna', '2025-03-27'),
('Sloba Radanovic','Peta scena', 'Pop-folk', '2025-03-28'),
('Van Gogh','Treca scena', 'Rock', '2025-03-29');
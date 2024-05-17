CREATE TABLE Partok (
  nev_id INT PRIMARY KEY,
  nev VARCHAR(100) NOT NULL
);

CREATE TABLE Megye (
  megye_id INT PRIMARY KEY,
  nev VARCHAR(100) NOT NULL
);

CREATE TABLE Valasztasikerulet (
  kerulet_id INT PRIMARY KEY,
  nev VARCHAR(100) NOT NULL,
  megye_id INT,
  varos VARCHAR(100),
  tamogatott_part_id INT,
  FOREIGN KEY (tamogatott_part_id) REFERENCES Partok(nev_id),
  FOREIGN KEY (megye_id) REFERENCES Megye(megye_id)
);

CREATE TABLE Egyeni (
  egyeni_id INT,
  nev VARCHAR(100) NOT NULL,
  tamogatott_part_id INT,
  valasztasi_kerulet_id INT,
  FOREIGN KEY (tamogatott_part_id) REFERENCES Partok(nev_id),
  FOREIGN KEY (valasztasi_kerulet_id) REFERENCES Valasztasikerulet(kerulet_id),
  PRIMARY KEY (egyeni_id, valasztasi_kerulet_id)
);

CREATE TABLE Orszagoslistak (
  lista_id INT PRIMARY KEY,
  nev VARCHAR(100) NOT NULL,
  tamogatott_part_id INT,
  FOREIGN KEY (tamogatott_part_id) REFERENCES Partok(nev_id)
);

CREATE TABLE Valasztasiadatok (
  ev INT,
  orszagoslista_id INT,
  egyeni_id INT,
  valasztokerulet_id INT,
  szavazat INT,
  FOREIGN KEY (orszagoslista_id) REFERENCES Orszagoslistak(lista_id),
  FOREIGN KEY (egyeni_id, valasztokerulet_id) REFERENCES Egyeni(egyeni_id, valasztasi_kerulet_id)
);

CREATE TABLE Reszvetel (
  megye_id INT,
  reszveteli_arany DECIMAL(4,2),
  FOREIGN KEY (megye_id) REFERENCES Megye(megye_id)
);

CREATE INDEX idx_Partok_nev ON Partok (nev);
CREATE INDEX idx_Megye_nev ON Megye (nev);
CREATE INDEX idx_Valasztasikerulet_varos ON Valasztasikerulet (varos);
CREATE INDEX idx_Egyeni_nev ON Egyeni (nev);
CREATE INDEX idx_Orszagoslistak_nev ON Orszagoslistak (nev);
CREATE INDEX idx_Valasztasiadatok_ev ON Valasztasiadatok (ev);
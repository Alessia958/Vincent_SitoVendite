/*
=======================
CREAZIONE TABELLE
=======================
*/

DROP TABLE IF EXISTS ProdottiOrdine;
DROP TABLE IF EXISTS Valutazione;
DROP TABLE IF EXISTS Ordine;
DROP TABLE IF EXISTS Carrello;
DROP TABLE IF EXISTS Utente;
DROP TABLE IF EXISTS Administrator;
DROP TABLE IF EXISTS Prodotto;

CREATE TABLE Utente (
  IdUtente  	BIGINT AUTO_INCREMENT PRIMARY KEY,
  Username 		VARCHAR(127) NOT NULL,
  Email 			VARCHAR(255) NOT NULL,
  Nome 				VARCHAR(127) NOT NULL,
  Cognome 		VARCHAR(127) NOT NULL,
  Password 		VARCHAR(127) NOT NULL,
  Citta 			VARCHAR(127) NOT NULL,
  Via 				VARCHAR(127) NOT NULL,
  Civico			VARCHAR(127) NOT NULL,
  Cap 				SMALLINT NOT NULL,
  UNIQUE(Username)
);

CREATE TABLE Administrator (
  IdAdmin			BIGINT AUTO_INCREMENT PRIMARY KEY,
  Username 		VARCHAR(127) NOT NULL,
  Email 			VARCHAR(255),
  Nome 				VARCHAR(127) NOT NULL,
  Cognome 		VARCHAR(127) NOT NULL,
  Password 		VARCHAR(127) NOT NULL,
  UNIQUE(Username)
);

CREATE TABLE Ordine (
  IdOrdine 				BIGINT AUTO_INCREMENT PRIMARY KEY,
  DataOrdine	 		DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  Citta 					VARCHAR(127) NOT NULL,
  Via 						VARCHAR(127) NOT NULL,
  Cap 						SMALLINT NOT NULL,
  Utente 					BIGINT NOT NULL,
  FOREIGN KEY (Utente) REFERENCES Utente (IdUtente) ON UPDATE CASCADE
);

CREATE TABLE Prodotto (
  IdProdotto 					BIGINT AUTO_INCREMENT PRIMARY KEY,
  Nome 								VARCHAR(127) NOT NULL UNIQUE,
  Descrizione			 		TEXT,
  Prezzo 							FLOAT(9,2) NOT NULL,
  Taglia 							ENUM('S','M','L'),
  Tipo 								ENUM('Borsa','Portafoglio','Zaino') NOT NULL,
  MediaValutazione  	FLOAT(2,1) DEFAULT 0,
  Foto								VARCHAR(127)
);

CREATE TABLE ProdottiOrdine (
  IdProdotto 			BIGINT,
  IdOrdine 				BIGINT,
  Quantita 				INTEGER DEFAULT 0,
  PRIMARY KEY (IdProdotto, IdOrdine),
  FOREIGN KEY (IdProdotto) REFERENCES Prodotto (IdProdotto) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (IdOrdine) REFERENCES Ordine (IdOrdine) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE Valutazione(
  Utente        BIGINT NOT NULL,
  IdProdotto    BIGINT,
  Voto          TINYINT NOT NULL,
  PRIMARY KEY (Utente,IdProdotto),
  FOREIGN KEY (Utente) REFERENCES Utente(IdUtente) ON DELETE CASCADE,
  FOREIGN KEY (IdProdotto) REFERENCES Prodotto(IdProdotto) ON DELETE CASCADE
);

CREATE TABLE Carrello (
  IdUtente        BIGINT NOT NULL,
  IdProdotto      BIGINT NOT NULL,
  Quantita        BIGINT NOT NULL,
  PRIMARY KEY (IdUtente, IdProdotto),
  FOREIGN KEY (IdProdotto) REFERENCES Prodotto (IdProdotto) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY (IdUtente) REFERENCES Utente (IdUtente) ON DELETE CASCADE ON UPDATE CASCADE
);

/*
=======================
TRIGGER
=======================
*/

Delimiter $
CREATE TRIGGER FaiMediaValutazione
after INSERT ON Valutazione
FOR EACH ROW
  BEGIN
    UPDATE Prodotto
    SET MediaValutazione = (SELECT AVG(Voto)
                            FROM Valutazione
                            WHERE Valutazione.IdProdotto = NEW.IdProdotto)
    WHERE IdProdotto = NEW.IdProdotto;

  END $
Delimiter ;

Delimiter $
CREATE TRIGGER RifaiMediaValutazione
after UPDATE ON Valutazione
FOR EACH ROW
  BEGIN
    UPDATE Prodotto
    SET MediaValutazione = (SELECT AVG(Voto)
                            FROM Valutazione
                            WHERE Valutazione.IdProdotto = NEW.IdProdotto)
    WHERE IdProdotto = NEW.IdProdotto;

  END $
Delimiter ;

/*
=======================
RIEMPIMENTO TABELLE
=======================
*/

INSERT INTO Utente (Username, Email, Nome, Cognome, Password, Citta, Via, Civico, Cap)
VALUES ('user', 'user@hotmail.it', 'User', 'User', '12dea96fec20593566ab75692c9949596833adc9', 'Bassano', 'Trieste', '22', 36061);

INSERT INTO Administrator (Username, Email, Nome, Cognome, Password)
VALUES ('admin','admin@hotmail.it','Admin','Admin','d033e22ae348aeb5660fc2140aec35850c4da997');

INSERT INTO Prodotto (Nome,	Descrizione, Prezzo, Taglia, Tipo, Foto)
VALUES ('Abed', 'Zaino di dimensione media con dei dinosauri disegnati sopra', '40', 'M', 'Zaino', 'Pagine/Immagini/zaini/1f.png'),
  ('Mushu', 'Zaino di dimensione piccola di colore prevalentemente blu, grigi e rossi', '30', 'S', 'Zaino', 'Pagine/Immagini/zaini/2f.png'),
  /*('Virginia', '', '50', 'L', 'Zaino', 'Pagine/Immagini/zaini/3f.png'),
  ('Eve', '', '30', 'S', 'Zaino', 'Pagine/Immagini/zaini/4f.png'),
  ('Agrabah', '', '40', 'M', 'Zaino', 'Pagine/Immagini/zaini/5f.png'),
  ('Pikos', '', '50', 'L', 'Zaino', 'Pagine/Immagini/zaini/6f.png'),
  ('Quanto', '', '40', 'M', 'Zaino', 'Pagine/Immagini/zaini/7f.png'),
  ('Ristan', '', '30', 'S', 'Zaino', 'Pagine/Immagini/zaini/8f.png'),
  ('Random', '', '50', 'L', 'Zaino', 'Pagine/Immagini/zaini/9f.png'),*/
  ('Violet', 'Borsa piccola di colore verde e grigio', '20', 'S', 'Borsa', 'Pagine/Immagini/borse/1f.png'),
  ('Clemom', 'Borsa media di colore grigio e beige', '30', 'M', 'Borsa', 'Pagine/Immagini/borse/2f.png'),
  /*('Mirto', '', '40', 'L', 'Borsa', 'Pagine/Immagini/borse/3f.png'),
  ('Marianne', '', '30', 'M', 'Borsa', 'Pagine/Immagini/borse/4f.png'),
  ('Manu', '', '40', 'L', 'Borsa', 'Pagine/Immagini/borse/5f.png'),
  ('Giudix', '', '30', 'M', 'Borsa', 'Pagine/Immagini/borse/6f.png'),
  ('Bagind', '', '30', 'M', 'Borsa', 'Pagine/Immagini/borse/7f.png'),
  ('Qualfind', '', '20', 'S', 'Borsa', 'Pagine/Immagini/borse/8f.png'),
  ('Entei', '', '20', 'S', 'Borsa', 'Pagine/Immagini/borse/9f.png'),*/
  ('Ursidae', 'Portafoglio piccolo di colore marrone e beige con orsi disegnati sopra', '45', 'S', 'Portafoglio', 'Pagine/Immagini/portafogli/1f.png'),
  ('Pois', 'Portafoglio di media grandezza rosso e blu a pois', '55', 'M', 'Portafoglio', 'Pagine/Immagini/portafogli/2f.png');
 /* ('Koda', '', '45', 'S', 'Portafoglio', 'Pagine/Immagini/portafogli/3f.png'),
  ('Gloe', '', '55', 'M', 'Portafoglio', 'Pagine/Immagini/portafogli/4f.png'),
  ('Youshu', '', '65', 'L', 'Portafoglio', 'Pagine/Immagini/portafogli/5f.png'),
  ('Sundae', '', '65', 'L', 'Portafoglio', 'Pagine/Immagini/portafogli/6f.png'),
  ('Bondak', '', '55', 'M', 'Portafoglio', 'Pagine/Immagini/portafogli/7f.png'),
  ('Kazai', '', '45', 'S', 'Portafoglio', 'Pagine/Immagini/portafogli/8f.png'),
  ('Bulldog', '', '55', 'M', 'Portafoglio', 'Pagine/Immagini/portafogli/9f.png')*/

INSERT INTO Valutazione(Utente, IdProdotto, Voto)
VALUES (1, 1, 4),
  (1, 2, 4);
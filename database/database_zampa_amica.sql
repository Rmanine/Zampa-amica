CREATE TABLE
	Utente (
		Email VARCHAR(50) PRIMARY KEY,
		Username VARCHAR(50),
		Password VARCHAR(50)
	);

CREATE TABLE
	Animale (
		ID SERIAL PRIMARY KEY,
		Nome VARCHAR(50),
		Specie VARCHAR(50),
		Eta INT,
		Genere VARCHAR(50),
		Descrizione TEXT,
		Immagine VARCHAR(255)
	);

CREATE TABLE
	Cane (
		ID INT PRIMARY KEY,
		Taglia VARCHAR(50),
		FOREIGN KEY (ID) REFERENCES Animale (ID)
	);

CREATE TABLE
	Preferiti (
		Utente VARCHAR(50),
		Animale INT,
		PRIMARY KEY (Utente, Animale),
		FOREIGN KEY (Utente) REFERENCES Utente (Email),
		FOREIGN KEY (Animale) REFERENCES Animale (ID)
	);

CREATE TABLE
	Prenotazione (
		ID SERIAL PRIMARY KEY,
		Utente VARCHAR(50),
		Animale INT,
		DataOra TIMESTAMP,
		FOREIGN KEY (Utente) REFERENCES Utente (Email),
		FOREIGN KEY (Animale) REFERENCES Animale (ID)
	);

CREATE TABLE
	Richieste (
		Email VARCHAR(50) PRIMARY KEY,
		Nome VARCHAR(255) NOT NULL,
		Cognome VARCHAR(255) NOT NULL,
		Telefono VARCHAR(255) NOT NULL
	);


INSERT INTO
	Utente (Email, Username, Password)
VALUES
	('user@email.com', 'user', 'user'),
	('admin@email.com', 'admin', 'admin');

INSERT INTO
	Animale (
		ID,
		Nome,
		Specie,
		Eta,
		Genere,
		Descrizione,
		Immagine
	)
VALUES
	(
		DEFAULT,
		'Alfredo',
		'Cane',
		4,
		'Maschio',
		'Alfredo è un magnifico esemplare di Corgi, caratterizzato dal tipico corpo allungato e dalle zampette corte, che gli conferiscono un aspetto irresistibile.
Alfredo è un cane di taglia piccola, estremamente intelligente, attento e molto affettuoso. Possiede un’indole vivace e giocosa ed è alla ricerca di una famiglia stabile e amorevole che possa garantirgli l’esercizio fisico e la stimolazione mentale di cui ha bisogno. È il compagno ideale per chi cerca un cane fedele e di grande carattere.',
		'img_database/alfredo.jpg'
	),
	(
		DEFAULT,
		'Bagigio',
		'Gatto',
		5,
		'Maschio',
		'Bagigio è uno splendido gatto con un mantello Silver Tabby di grande impatto visivo. Le sue marcature grigie scure e argentate lo rendono un esemplare di notevole bellezza ed eleganza.
Con una corporatura robusta e occhi grandi ed espressivi, Bagigio è un gatto tranquillo, ideale per chi cerca un compagno felino che apprezzi i ritmi domestici. È profondamente affettuoso e ama le sessioni di coccole, specialmente quando è rilassato. Bagigio si adatta bene alla vita d’appartamento, portando calma e raffinatezza nell’ambiente.',
		'img_database/bagigio.jpg'
	),
	(
		DEFAULT,
		'Franco',
		'Cane',
		7,
		'Maschio',
		'Franco è un adorabile cane di taglia piccola, con un pelo corto color fulvo.
Franco è un cane estremamente dolce e sensibile. È probabile che si adatti bene alla vita domestica, cercando la vicinanza dei suoi umani. Cerca una famiglia che apprezzi la sua natura tranquilla e lo coinvolga in momenti di gioco e, soprattutto, in lunghe sessioni di coccole sul divano.
Franco è pronto a dimostrare quanto può essere grande l’amore in un formato compatto.',
		'img_database/franco.jpg'
	),
	(
		DEFAULT,
		'Gigia',
		'Gatto',
		3,
		'Femmina',
		'Gigia è una splendida gatta bicolore, con un elegante mantello bianco e nero. È una gatta che ricerca la comodità e la vicinanza umana. Gigia è l’ideale per chi cerca una compagnia felina che sappia apprezzare le routine rilassate della casa. 
Gigia è in attesa di un divano accogliente e di una famiglia che si innamori della sua maestosa semplicità.',
		'img_database/gigia.jpg'
	),
	(
		DEFAULT,
		'Rex',
		'Cane',
		3,
		'Maschio',
		'Rex è un cane di taglia media con un mantello bicolore bianco e fulvo, che spicca per la sua espressione intelligente e il portamento fiero.
Questo cane è un compagno leale e attento: è energico e apprezza le passeggiate regolari e i giochi che stimolano la sua mente. Rex cerca una famiglia coinvolta e dinamica, pronta a dedicargli tempo ed educazione positiva.',
		'img_database/rex.jpg'
	),
	(
		DEFAULT,
		'Wanda',
		'Gatto',
		4,
		'Femmina',
		'Wanda è una splendida gatta con un mantello tricolore, dove il bianco brillante si mescola con eleganti sfumature color crema e marrone chiaro.
È una gatta che cattura l’attenzione non solo per la sua bellezza, ma per la sua espressione intelligente e misurata. Ha una personalità decisa ma affettuosa. Wanda cerca una casa che rispetti i suoi tempi e che la riempia di attenzioni. È la compagna ideale per chi desidera un gatto con una forte personalità e un aspetto unico.',
		'img_database/wanda.jpg'
	),
	(
		DEFAULT,
		'Lilli',
		'Cane',
		13,
		'Femmina',
		'AGGIUNGERE DESCRIZIONE',
		'img_database/lilli.jpg'
	);

INSERT INTO
	Cane (ID, Taglia)
VALUES
	(1, 'Piccola'),
	(3, 'Piccola'),
	(5, 'Media'),
	(7, 'Piccola');

INSERT INTO
	Preferiti (Utente, Animale)
VALUES
	('user@email.com', 3),
	('user@email.com', 2);

INSERT INTO
	Prenotazione (ID, Utente, Animale, DataOra)
VALUES
	(
		DEFAULT,
		'user@email.com',
		3,
		'2025-12-05 15:30:00'
	);

INSERT INTO
	Richieste (Email, Nome, Cognome, Telefono)
VALUES
	(
		'davide.loparco@studenti.unipd.it',
		'Davide',
		'Loparco',
		'1234567890'
	),
	(
		'amoicani@gmail.com',
		'Giovanni',
		'Verdi',
		'0987654321'
	);
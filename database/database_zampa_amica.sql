CREATE TABLE
	Utente (
		Email VARCHAR(50) PRIMARY KEY,
		Username VARCHAR(50),
		Password VARCHAR(50)
	);

CREATE TABLE
	Animale (
		ID INT AUTO_INCREMENT PRIMARY KEY,
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
		FOREIGN KEY (ID) REFERENCES Animale (ID) ON DELETE CASCADE
	);

CREATE TABLE
	Preferiti (
		Utente VARCHAR(50),
		Animale INT,
		PRIMARY KEY (Utente, Animale),
		FOREIGN KEY (Utente) REFERENCES Utente (Email) ON DELETE CASCADE,
		FOREIGN KEY (Animale) REFERENCES Animale (ID) ON DELETE CASCADE
	);

CREATE TABLE
	Prenotazione (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		Utente VARCHAR(50),
		Animale INT,
		DataOra TIMESTAMP,
		FOREIGN KEY (Utente) REFERENCES Utente (Email) ON DELETE CASCADE,
		FOREIGN KEY (Animale) REFERENCES Animale (ID) ON DELETE CASCADE
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
		1,
		'Lucky',
		'Cane',
		3,
		'Maschio',
		'Lucky è un esplosione di energia con un bellissimo mantello bianco e nero. Ha uno sguardo intelligente e vive per giocare: se hai una pallina da lanciargli, sarai il suo migliore amico per sempre. Cerca un compagno che ami le avventure all’aria aperta.',
		'1.jpg'
	),
	(
		2,
		'Thor',
		'Cane',
		5,
		'Maschio',
		'Non lasciarti ingannare dal suo aspetto fiero: Thor è in realtà un gigante dal cuore dolce. Ha un portamento nobile e attento, ma appena varca la soglia di casa si trasforma in un cucciolone che cerca solo carezze e un posto morbido dove accucciarsi vicino a te.',
		'2.jpg'
	),
	(
		3,
		'Felix',
		'Gatto',
		4,
		'Maschio',
		'Con la sua elegante livrea bianca e nera, Felix sembra indossare perennemente uno smoking. È un gatto di grande classe, tranquillo e osservatore. Adora posizionarsi nei punti strategici della casa per controllare il suo regno, ma non rifiuta mai una sessione di grattini dietro le orecchie.',
		'3.jpg'
	),
	(
		4,
		'Brusco',
		'Cane',
		6,
		'Maschio',
		'Brusco è un simpaticissimo Bulldog dall’espressione imbronciata che nasconde un carattere d’oro. La vita atletica non fa per lui: è un professionista del relax, campione olimpico di pisolini sul divano e grande amante del buon cibo. Il compagno perfetto per serate film e coccole.',
		'4.jpg'
	),
	(
		5,
		'Luna',
		'Gatto',
		2,
		'Femmina',
		'Luna è una creatura delicata e silenziosa, con un musetto dolcissimo. Inizialmente può sembrare timida, ma basta un po’ di pazienza per scoprire il suo lato affettuoso. Cerca un ambiente sereno e mani gentili che sappiano rassicurarla e farla sentire protetta.',
		'5.jpg'
	),
	(
		6,
		'Spike',
		'Cane',
		8,
		'Maschio',
		'Un piccoletto che non dimostra affatto la sua età. Spike ha lo spirito di un leone in un corpo tascabile: è curioso, vigile e incredibilmente devoto al suo padrone. Adora passeggiare annusando ogni angolo del mondo per poi tornare felice nella sua cuccia.',
		'6.jpg'
	),
	(
		7,
		'Molly',
		'Gatto',
		3,
		'Femmina',
		'Molly ha due occhi verdi magnetici che sembrano smeraldi. È la classica gatta di casa: curiosa quanto basta, indipendente ma presente. Ama esplorare buste della spesa e scatole di cartone, per poi venire a cercarti facendo le fusa quando è ora della pappa o delle coccole.',
		'7.jpg'
	),
	(
		8,
		'Argo',
		'Cane',
		4,
		'Maschio',
		'Argo ha l’eleganza innata dei cani da caccia e un fisico atletico scolpito per il movimento. È un cane dall’anima nobile e sensibile, che ha bisogno di sfogare la sua energia correndo libero. Perfetto per chi ama il trekking e cerca un compagno fedele che non si stanca mai.',
		'8.jpg'
	),
	(
		9,
		'Nuvola',
		'Gatto',
		5,
		'Femmina',
		'Una vera regina di bellezza, con un pelo lungo e soffice che richiede cure ma ripaga con una morbidezza incredibile. Nuvola sa di essere stupenda e si muove per casa con maestosità. È calma, pacifica e adora essere spazzolata mentre ti guarda con gratitudine.',
		'9.jpg'
	),
	(
		10,
		'Gizmo',
		'Cane',
		2,
		'Maschio',
		'Impossibile non sorridere guardando Gizmo! Con quelle orecchie enormi che sembrano captare ogni segnale e il suo sguardo vispo, è un concentrato di simpatia. È un cagnolino da compagnia eccezionale, sempre pronto a strapparti un sorriso con le sue buffe espressioni.',
		'10.jpg'
	),
	(
		11,
		'Lassie',
		'Cane',
		1,
		'Femmina',
		'Un batuffolo di pelo tricolore con occhi che brillano di intelligenza. Questa cucciola è dolcissima, impara alla velocità della luce ed è ansiosa di compiacere. È in quella fase meravigliosa in cui tutto è una scoperta: ha bisogno di una guida affettuosa per diventare una splendida adulta.',
		'11.jpg'
	),
	(
		12,
		'Birba',
		'Gatto',
		1,
		'Maschio',
		'Il nome dice tutto: Birba è un uragano di allegria. Per lui la vita è un gioco continuo, che si tratti di inseguire un filo d’erba o fare agguati amichevoli alle tue caviglie. Se cerchi un gattino che porti vita, risate e un pizzico di caos felice in casa, lui è quello giusto.',
		'12.jpg'
	),
	(
		13,
		'Oreo',
		'Cane',
		7,
		'Maschio',
		'Oreo ha lo sguardo profondo e saggio di chi ne ha viste tante ma non ha perso la fiducia nell’uomo. È un cane equilibrato, tranquillo, che non chiede molto se non una cuccia calda e una mano amica che lo accarezzi. La sua gratitudine sarà silenziosa ma immensa.',
		'13.jpg'
	),
	(
		14,
		'Ronf',
		'Gatto',
		6,
		'Maschio',
		'Ronf ha capito tutto della vita: perché correre quando si può dormire? È un maestro zen del riposo, capace di addormentarsi nelle posizioni più improbabili. È il gatto ideale per chi vuole una presenza rassicurante e pacifica in casa, un amico peloso che emana tranquillità.',
		'14.jpg'
	),
	(
		15,
		'Cleo',
		'Gatto',
		3,
		'Femmina',
		'Cleo è una gatta tricolore dallo spirito libero e indipendente. Ama godersi i raggi del sole in giardino o sul balcone e osservare la natura. Non è una gatta appiccicosa, ma sa regalare momenti di grande affetto quando è lei a decidere che è il momento delle coccole.',
		'15.jpg'
	),
	(
		16,
		'Pom',
		'Cane',
		4,
		'Maschio',
		'Un piccolo leoncino da salotto, soffice e vanitoso. Pom è un Volpino che adora essere al centro dell’attenzione e farsi ammirare. Molto vivace e chiacchierone, è un ottimo compagno di vita e avventure',
		'16.jpg'
	),
	(
		17,
		'Iggy',
		'Cane',
		2,
		'Maschio',
		'Compatto, muscoloso e con una faccia da fumetto, Iggy è un Boston Terrier pieno di gioia di vivere. È un cane socievole che va d’accordo con tutti e adora giocare e stare in compagnia. Impossibile sentirsi soli con lui nei paraggi.',
		'17.jpg'
	),
	(
		18,
		'Simba',
		'Gatto',
		1,
		'Maschio',
		'Una piccola tigre domestica dal manto rosso fuoco. Simba è avventuroso, coraggioso e atletico. Adora arrampicarsi sui tiragraffi più alti e osservare il mondo dall’alto. Ha un carattere solare ed espansivo, tipico dei gatti rossi, ed è sempre pronto a interagire con gli umani.',
		'18.jpg'
	),
	(
		19,
		'Ombra',
		'Gatto',
		4,
		'Femmina',
		'Con il suo manto grigio vellutato e gli occhi color ambra, Ombra è l’eleganza fatta gatto. È una presenza discreta e silenziosa, quasi mistica. Non ama il caos, ma si lega profondamente a chi sa rispettare i suoi tempi, diventando un’ombra affettuosa che ti segue per casa.',
		'19.jpg'
	);

INSERT INTO
	Cane (ID, Taglia)
VALUES
	(1, 'Media'),
	(2, 'Grande'),
	(4, 'Media'),
	(6, 'Piccola'),
	(8, 'Grande'),
	(10, 'Piccola'),
	(11, 'Media'),
	(13, 'Media'),
	(16, 'Piccola'),
	(17, 'Piccola');

INSERT INTO
	Preferiti (Utente, Animale)
VALUES
	('user@email.com', 3),
	('user@email.com', 2);

INSERT INTO
	Prenotazione (Utente, Animale, DataOra)
VALUES
	('user@email.com', 3, '2025-12-05 15:30:00');

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
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
	Richiesta_Volontariato (
		Email VARCHAR(50) PRIMARY KEY,
		Nome VARCHAR(50) NOT NULL,
		Cognome VARCHAR(50) NOT NULL,
		Telefono VARCHAR(10) NOT NULL,
		DataOra TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);


INSERT INTO
	Utente (Email, Username, Password)
VALUES
	('user@email.com', 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb'),
	('user1@email.com', 'user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90');

INSERT INTO Animale (Nome, Specie, EtaMesi, Genere, Taglia, Descrizione, Immagine) 
VALUES 
	('Lucky','Cane',36,'Maschio','Medio','Lucky è un esplosione di energia con un bellissimo mantello bianco e nero. Ha uno sguardo intelligente e vive per giocare: se hai una pallina da lanciargli, sarai il suo migliore amico per sempre. Cerca un compagno che ami le avventure all\'aria aperta.','img/assets/1.jpg'),
	('Thor','Cane',60,'Maschio','Grande', 'Non lasciarti ingannare dal suo aspetto fiero: Thor è in realtà un gigante dal cuore dolce. Ha un portamento nobile e attento, ma appena varca la soglia di casa si trasforma in un cucciolone che cerca solo carezze e un posto morbido dove accucciarsi vicino a te.','img/assets/2.jpg'),
	('Felix','Gatto',48,'Maschio',NULL,'Con la sua elegante livrea bianca e nera, Felix sembra indossare perennemente uno smoking. È un gatto di grande classe, tranquillo e osservatore. Adora posizionarsi nei punti strategici della casa per controllare il suo regno, ma non rifiuta mai una sessione di grattini dietro le orecchie.','img/assets/3.jpg'),
	('Brusco','Cane',72,'Maschio','Grande','Brusco è un simpaticissimo Bulldog dall\'espressione imbronciata che nasconde un carattere d\'oro. La vita atletica non fa per lui: è un professionista del relax, campione olimpico di pisolini sul divano e grande amante del buon cibo. Il compagno perfetto per serate film e coccole.','img/assets/4.jpg'),
	('Luna','Gatto',24,'Femmina',NULL,'Luna è una creatura delicata e silenziosa, con un musetto dolcissimo. Inizialmente può sembrare timida, ma basta un po\' di pazienza per scoprire il suo lato affettuoso. Cerca un ambiente sereno e mani gentili che sappiano rassicurarla e farla sentire protetta.','img/assets/5.jpg'),
	('Spike','Cane',96,'Maschio','Piccolo','Un piccoletto che non dimostra affatto la sua età. Spike ha lo spirito di un leone in un corpo tascabile: è curioso, vigile e incredibilmente devoto al suo padrone. Adora passeggiare annusando ogni angolo del mondo per poi tornare felice nella sua cuccia.','img/assets/6.jpg'),
	('Molly','Gatto',36,'Femmina',NULL,'Molly ha due occhi verdi magnetici che sembrano smeraldi. È la classica gatta di casa: curiosa quanto basta, indipendente ma presente. Ama esplorare buste della spesa e scatole di cartone, per poi venire a cercarti facendo le fusa quando è ora della pappa o delle coccole.','img/assets/7.jpg'),
	('Argo','Cane',48,'Maschio','Medio','Argo ha l\'eleganza innata dei cani da caccia e un fisico atletico scolpito per il movimento. È un cane dall\'anima nobile e sensibile, che ha bisogno di sfogare la sua energia correndo libero. Perfetto per chi ama il trekking e cerca un compagno fedele che non si stanca mai.','img/assets/8.jpg'),
	('Nuvola','Gatto',60,'Femmina',NULL,'Una vera regina di bellezza, con un pelo lungo e soffice che richiede cure ma ripaga con una morbidezza incredibile. Nuvola sa di essere stupenda e si muove per casa con maestosità. È calma, pacifica e adora essere spazzolata mentre ti guarda con gratitudine.','img/assets/9.jpg'),
	('Gizmo','Cane',24,'Maschio','Grande','Impossibile non sorridere guardando Gizmo! Con quelle orecchie enormi che sembrano captare ogni segnale e il suo sguardo vispo, è un concentrato di simpatia. È un cagnolino da compagnia eccezionale, sempre pronto a strapparti un sorriso con le sue buffe espressioni.','img/assets/10.jpg'),
	('Lassie','Cane',6,'Femmina','Piccolo','Un batuffolo di pelo tricolore con occhi che brillano di intelligenza. Questa cucciola è dolcissima, impara alla velocità della luce ed è ansiosa di compiacere. È in quella fase meravigliosa in cui tutto è una scoperta: ha bisogno di una guida affettuosa per diventare una splendida adulta.','img/assets/11.jpg'),
	('Birba','Gatto',8,'Maschio',NULL,'Il nome dice tutto: Birba è un uragano di allegria. Per lui la vita è un gioco continuo, che si tratti di inseguire un filo d\'erba o fare agguati amichevoli alle tue caviglie. Se cerchi un gattino che porti vita, risate e un pizzico di caos felice in casa, lui è quello giusto.','img/assets/12.jpg'),
	('Oreo','Cane',84,'Maschio','Medio','Oreo ha lo sguardo profondo e saggio di chi ne ha viste tante ma non ha perso la fiducia nell\'uomo. È un cane equilibrato, tranquillo, che non chiede molto se non una cuccia calda e una mano amica che lo accarezzi. La sua gratitudine sarà silenziosa ma immensa.','img/assets/13.jpg'),
	('Ronf','Gatto',72,'Maschio',NULL,'Ronf ha capito tutto della vita: perché correre quando si può dormire? È un maestro zen del riposo, capace di addormentarsi nelle posizioni più improbabili. È il gatto ideale per chi vuole una presenza rassicurante e pacifica in casa, un amico peloso che emana tranquillità.','img/assets/14.jpg'),
	('Cleo','Gatto',36,'Femmina',NULL,'Cleo è una gatta tricolore dallo spirito libero e indipendente. Ama godersi i raggi del sole in giardino o sul balcone e osservare la natura. Non è una gatta appiccicosa, ma sa regalare momenti di grande affetto quando è lei a decidere che è il momento delle coccole.','img/assets/15.jpg'),
	('Pom','Cane',48,'Maschio','Piccolo','Un piccolo leoncino da salotto, soffice e vanitoso. Pom è un Volpino che adora essere al centro dell\'attenzione e farsi ammirare. Molto vivace e chiacchierone, è un ottimo compagno di vita e avventure','img/assets/16.jpg'),
	('Iggy','Cane',24,'Maschio','Piccolo','Compatto, muscoloso e con una faccia da fumetto, Iggy è un Boston Terrier pieno di gioia di vivere. È un cane socievole che va d\'accordo con tutti e adora giocare e stare in compagnia. Impossibile sentirsi soli con lui nei paraggi.','img/assets/17.jpg'),
	('Simba','Gatto',12,'Maschio',NULL,'Una piccola tigre domestica dal manto rosso fuoco. Simba è avventuroso, coraggioso e atletico. Adora arrampicarsi sui tiragraffi più alti e osservare il mondo dall\'alto. Ha un carattere solare ed espansivo, tipico dei gatti rossi, ed è sempre pronto a interagire con gli umani.','img/assets/18.jpg'),
	('Ombra','Gatto',48,'Femmina',NULL,'Con il suo manto grigio vellutato e gli occhi color ambra, Ombra è l\'eleganza fatta gatto. È una presenza discreta e silenziosa, quasi mistica. Non ama il caos, ma si lega profondamente a chi sa rispettare i suoi tempi, diventando un\'ombra affettuosa che ti segue per casa.','img/assets/19.jpg');

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
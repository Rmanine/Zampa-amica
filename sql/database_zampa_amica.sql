CREATE TABLE
	Utente (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		Email VARCHAR(50) NOT NULL UNIQUE,
		Username VARCHAR(50) NOT NULL UNIQUE,
		Password VARCHAR(64) NOT NULL -- Memorizzato in SHA256 che produce sempre 64 caratteri
	);

CREATE TABLE
	Animale (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		Nome VARCHAR(50) NOT NULL,
		Specie VARCHAR(50) NOT NULL,
		EtaMesi INT NOT NULL, -- Età in mesi
		Genere VARCHAR(50) NOT NULL,
		Taglia VARCHAR(50), -- Opzionale poichè attributo legato solo ai cani
		Descrizione VARCHAR(500), -- Opzionale
		Immagine VARCHAR(255) -- Opzionale
	);

CREATE TABLE
	Prenotazione (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		UtenteID INT NOT NULL,
		AnimaleID INT NOT NULL,
		DataOra DATE NOT NULL,
		Note VARCHAR(255) NULL,
		FOREIGN KEY (UtenteID) REFERENCES Utente (ID) ON DELETE CASCADE,
		FOREIGN KEY (AnimaleID) REFERENCES Animale (ID) ON DELETE CASCADE
	);

CREATE TABLE
	Richiesta_Volontariato (
		Email VARCHAR(50) PRIMARY KEY,
		Nome VARCHAR(50) NOT NULL,
		Cognome VARCHAR(50) NOT NULL,
		Telefono VARCHAR(20) NOT NULL,
		DataOra TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);

INSERT INTO
	Utente (Email, Username, Password)
VALUES
	('user@email.com', 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb'),
	('user1@email.com', 'user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90');

INSERT INTO 
	Animale (Nome, Specie, EtaMesi, Genere, Taglia, Descrizione, Immagine) 
VALUES 
    ('Lucky','Cane',36,'Maschio','Medio','Lucky è un''esplosione di energia con un bellissimo mantello bianco e nero. Ha uno sguardo intelligente e vive per giocare: se hai una pallina da lanciargli, sarai il suo migliore amico per sempre. Cerca un compagno che ami le avventure all''aria aperta.','img/assets/1.jpg'),
    ('Thor','Cane',60,'Maschio','Grande', 'Non lasciarti ingannare dal suo aspetto fiero: Thor è in realtà un gigante dal cuore dolce. Ha un portamento nobile e attento, ma appena varca la soglia di casa si trasforma in un cucciolone che cerca solo carezze e un posto morbido dove accucciarsi vicino a te.','img/assets/2.jpg'),
    ('Felix','Gatto',48,'Maschio',NULL,'Con la sua elegante livrea bianca e nera, Felix sembra indossare perennemente uno smoking. È un gatto di grande classe, tranquillo e osservatore. Adora posizionarsi nei punti strategici della casa per controllare il suo regno, ma non rifiuta mai una sessione di grattini dietro le orecchie.','img/assets/3.jpg'),
    ('Brusco','Cane',72,'Maschio','Grande','Brusco è un simpaticissimo Bulldog dall''espressione imbronciata che nasconde un carattere d''oro. La vita atletica non fa per lui: è un professionista del relax, campione olimpico di pisolini sul divano e grande amante del buon cibo. Il compagno perfetto per serate film e coccole.','img/assets/4.jpg'),
    ('Luna','Gatto',24,'Femmina',NULL,'Luna è una creatura delicata e silenziosa, con un musetto dolcissimo. Inizialmente può sembrare timida, ma basta un po'' di pazienza per scoprire il suo lato affettuoso. Cerca un ambiente sereno e mani gentili che sappiano rassicurarla e farla sentire protetta.','img/assets/5.jpg'),
    ('Spike','Cane',96,'Maschio','Piccolo','Un piccoletto che non dimostra affatto la sua età. Spike ha lo spirito di un leone in un corpo tascabile: è curioso, vigile e incredibilmente devoto al suo padrone. Adora passeggiare annusando ogni angolo del mondo per poi tornare felice nella sua cuccia.','img/assets/6.jpg'),
    ('Molly','Gatto',36,'Femmina',NULL,'Molly ha due occhi verdi magnetici che sembrano smeraldi. È la classica gatta di casa: curiosa quanto basta, indipendente ma presente. Ama esplorare buste della spesa e scatole di cartone, per poi venire a cercarti facendo le fusa quando è ora della pappa o delle coccole.','img/assets/7.jpg'),
    ('Argo','Cane',48,'Maschio','Medio','Argo ha l''eleganza innata dei cani da caccia e un fisico atletico scolpito per il movimento. È un cane dall''anima nobile e sensibile, che ha bisogno di sfogare la sua energia correndo libero. Perfetto per chi ama il trekking e cerca un compagno fedele che non si stanca mai.','img/assets/8.jpg'),
    ('Nuvola','Gatto',60,'Femmina',NULL,'Una vera regina di bellezza, con un pelo lungo e soffice che richiede cure ma ripaga con una morbidezza incredibile. Nuvola sa di essere stupenda e si muove per casa con maestosità. È calma, pacifica e adora essere spazzolata mentre ti guarda con gratitudine.','img/assets/9.jpg'),
    ('Gizmo','Cane',24,'Maschio','Grande','Impossibile non sorridere guardando Gizmo! Con quelle orecchie enormi che sembrano captare ogni segnale e il suo sguardo vispo, è un concentrato di simpatia. È un cagnolino da compagnia eccezionale, sempre pronto a strapparti un sorriso con le sue buffe espressioni.','img/assets/10.jpg'),
    ('Lassie','Cane',6,'Femmina','Piccolo','Un batuffolo di pelo tricolore con occhi che brillano di intelligenza. Questa cucciola è dolcissima, impara alla velocità della luce ed è ansiosa di compiacere. È in quella fase meravigliosa in cui tutto è una scoperta: ha bisogno di una guida affettuosa per diventare una splendida adulta.','img/assets/11.jpg'),
    ('Birba','Gatto',8,'Maschio',NULL,'Il nome dice tutto: Birba è un uragano di allegria. Per lui la vita è un gioco continuo, che si tratti di inseguire un filo d''erba o fare agguati amichevoli alle tue caviglie. Se cerchi un gattino che porti vita, risate e un pizzico di caos felice in casa, lui è quello giusto.','img/assets/12.jpg'),
    ('Oreo','Cane',84,'Maschio','Medio','Oreo ha lo sguardo profondo e saggio di chi ne ha viste tante ma non ha perso la fiducia nell''uomo. È un cane equilibrato, tranquillo, che non chiede molto se non una cuccia calda e una mano amica che lo accarezzi. La sua gratitudine sarà silenziosa ma immensa.','img/assets/13.jpg'),
    ('Ronf','Gatto',72,'Maschio',NULL,'Ronf ha capito tutto della vita: perché correre quando si può dormire? È un maestro zen del riposo, capace di addormentarsi nelle posizioni più improbabili. È il gatto ideale per chi vuole una presenza rassicurante e pacifica in casa, un amico peloso che emana tranquillità.','img/assets/14.jpg'),
    ('Cleo','Gatto',36,'Femmina',NULL,'Cleo è una gatta tricolore dallo spirito libero e indipendente. Ama godersi i raggi del sole in giardino o sul balcone e osservare la natura. Non è una gatta appiccicosa, ma sa regalare momenti di grande affetto quando è lei a decidere che è il momento delle coccole.','img/assets/15.jpg'),
    ('Pom','Cane',48,'Maschio','Piccolo','Un piccolo leoncino da salotto, soffice e vanitoso. Pom è un Volpino che adora essere al centro dell''attenzione e farsi ammirare. Molto vivace e chiacchierone, è un ottimo compagno di vita e avventure.','img/assets/16.jpg'),
    ('Iggy','Cane',24,'Maschio','Piccolo','Compatto, muscoloso e con una faccia da fumetto, Iggy è un Boston Terrier pieno di gioia di vivere. È un cane socievole che va d''accordo con tutti e adora giocare e stare in compagnia. Impossibile sentirsi soli con lui nei paraggi.','img/assets/17.jpg'),
    ('Simba','Gatto',12,'Maschio',NULL,'Una piccola tigre domestica dal manto rosso fuoco. Simba è avventuroso, coraggioso e atletico. Adora arrampicarsi sui tiragraffi più alti e osservare il mondo dall''alto. Ha un carattere solare ed espansivo, tipico dei gatti rossi, ed è sempre pronto a interagire con gli umani.','img/assets/18.jpg'),
    ('Ombra','Gatto',48,'Femmina',NULL,'Con il suo manto grigio vellutato e gli occhi color ambra, Ombra è l''eleganza fatta gatto. È una presenza discreta e silenziosa, quasi mistica. Non ama il caos, ma si lega profondamente a chi sa rispettare i suoi tempi, diventando un''ombra affettuosa che ti segue per casa.','img/assets/19.jpg');

INSERT INTO 
	Prenotazione (UtenteID, AnimaleID, DataOra, Note)
VALUES 
    (1, 3, '2025-12-31 10:30:00', 'Prenotazione per visita conoscitiva'),
    (1, 2, '2026-01-15 15:00:00', NULL);

INSERT INTO
	Richiesta_Volontariato (Email, Nome, Cognome, Telefono)
VALUES
	('davide.loparco@studenti.unipd.it','Davide','Loparco','1234567890'),
	('amoicani@gmail.com','Giovanni','Verdi','0987654321');
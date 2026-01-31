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
		Lingua VARCHAR(2) NOT NULL DEFAULT "it", -- Codice Alpha-2 ISO 639-1 che rappresenta in che lingua è stato definito il nome dell'animale (es. 'Lucky' = en)
		Specie VARCHAR(50) NOT NULL,
		EtaMesi INT NOT NULL, -- Età in mesi
		Genere VARCHAR(50) NOT NULL,
		Taglia VARCHAR(50), -- Opzionale poichè attributo legato solo ai cani
		Descrizione VARCHAR(500), -- Opzionale
		Immagine VARCHAR(255) NOT NULL
	);

CREATE TABLE
	Prenotazione (
		ID INT AUTO_INCREMENT PRIMARY KEY,
		UtenteID INT NOT NULL,
		AnimaleID INT NOT NULL,
		Data DATE NOT NULL,
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
		Data TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	);

INSERT INTO
	Utente (Email, Username, Password)
VALUES
	('user@email.com', 'user', '04f8996da763b7a969b1028ee3007569eaf3a635486ddab211d512c85b9df8fb'),
	('user1@email.com', 'user1', '0a041b9462caa4a31bac3567e0b6e6fd9100787db2ab433d96f6d178cabfce90');

INSERT INTO 
	Animale (Nome, Lingua, Specie, EtaMesi, Genere, Taglia, Descrizione, Immagine) 
VALUES 
    ('Lucky','en','Cane',36,'Maschio','Medio','<span lang="en">Lucky</span> è un''esplosione di energia con un bellissimo mantello bianco e nero. Ha uno sguardo intelligente e vive per giocare: se hai una pallina da lanciargli, sarai il suo migliore amico per sempre. Cerca un compagno che ami le avventure all''aria aperta.','1.jpg'),
    ('Thor','it','Cane',60,'Maschio','Piccolo', 'Non lasciarti ingannare dal suo aspetto fiero: Thor è in realtà un gigante dal cuore dolce. Ha un portamento nobile e attento, ma appena varca la soglia di casa si trasforma in un cucciolone che cerca solo carezze e un posto morbido dove accucciarsi vicino a te.','2.jpg'),
    ('Felix','en','Gatto',48,'Maschio',NULL,'Con la sua elegante livrea bianca e nera, <span lang="en">Felix</span> sembra indossare perennemente uno <span lang="en">smoking</span>. È un gatto di grande classe, tranquillo e osservatore. Adora posizionarsi nei punti strategici della casa per controllare il suo regno, ma non rifiuta mai una sessione di grattini dietro le orecchie.','3.jpg'),
    ('Brusco','it','Cane',72,'Maschio','Piccolo','Brusco è un simpaticissimo Bulldog dall''espressione imbronciata che nasconde un carattere d''oro. La vita atletica non fa per lui: è un professionista del relax, campione olimpico di pisolini sul divano e grande amante del buon cibo. Il compagno perfetto per serate film e coccole.','4.jpg'),
    ('Luna','it','Gatto',24,'Femmina',NULL,'Luna è una creatura delicata e silenziosa, con un musetto dolcissimo. Inizialmente può sembrare timida, ma basta un po'' di pazienza per scoprire il suo lato affettuoso. Cerca un ambiente sereno e mani gentili che sappiano rassicurarla e farla sentire protetta.','5.jpg'),
    ('Spike','en','Cane',96,'Maschio','Piccolo','Un piccoletto che non dimostra affatto la sua età. <span lang="en">Spike</span> ha lo spirito di un leone in un corpo tascabile: è curioso, vigile e incredibilmente devoto al suo padrone. Adora passeggiare annusando ogni angolo del mondo per poi tornare felice nella sua cuccia.','6.jpg'),
    ('Molly','en','Gatto',36,'Femmina',NULL,'<span lang="en">Molly</span> ha due occhi verdi magnetici che sembrano smeraldi. È la classica gatta di casa: curiosa quanto basta, indipendente ma presente. Ama esplorare buste della spesa e scatole di cartone, per poi venire a cercarti facendo le fusa quando è ora della pappa o delle coccole.','7.jpg'),
    ('Argo','it','Cane',48,'Maschio','Grande','Argo ha l''eleganza innata dei cani da caccia e un fisico atletico scolpito per il movimento. È un cane dall''anima nobile e sensibile, che ha bisogno di sfogare la sua energia correndo libero. Perfetto per chi ama il trekking e cerca un compagno fedele che non si stanca mai.','8.jpg'),
    ('Nuvola','it','Gatto',60,'Femmina',NULL,'Una vera regina di bellezza, con un pelo lungo e soffice che richiede cure ma ripaga con una morbidezza incredibile. Nuvola sa di essere stupenda e si muove per casa con maestosità. È calma, pacifica e adora essere spazzolata mentre ti guarda con gratitudine.','9.jpg'),
    ('Gizmo','it','Cane',24,'Maschio','Piccolo','Impossibile non sorridere guardando Gizmo! Con quelle orecchie enormi che sembrano captare ogni segnale e il suo sguardo vispo, è un concentrato di simpatia. È un cagnolino da compagnia eccezionale, sempre pronto a strapparti un sorriso con le sue buffe espressioni.','10.jpg'),
    ('Lassie','en','Cane',6,'Femmina','Medio','Un batuffolo di pelo tricolore con occhi che brillano di intelligenza. Questa cucciola è dolcissima, impara alla velocità della luce ed è ansiosa di compiacere. È in quella fase meravigliosa in cui tutto è una scoperta: ha bisogno di una guida affettuosa per diventare una splendida adulta.','11.jpg'),
    ('Birbo','it','Gatto',8,'Maschio',NULL,'Il nome dice tutto: Birbo è un uragano di allegria. Per lui la vita è un gioco continuo, che si tratti di inseguire un filo d''erba o fare agguati amichevoli alle tue caviglie. Se cerchi un gattino che porti vita, risate e un pizzico di caos felice in casa, lui è quello giusto.','12.jpg'),
    ('Oreo','it','Cane',84,'Maschio','Medio','Oreo ha lo sguardo profondo e saggio di chi ne ha viste tante ma non ha perso la fiducia nell''uomo. È un cane equilibrato, tranquillo, che non chiede molto se non una cuccia calda e una mano amica che lo accarezzi. La sua gratitudine sarà silenziosa ma immensa.','13.jpg'),
    ('Ronf','it','Gatto',72,'Maschio',NULL,'Ronf ha capito tutto della vita: perché correre quando si può dormire? È un maestro zen del riposo, capace di addormentarsi nelle posizioni più improbabili. È il gatto ideale per chi vuole una presenza rassicurante e pacifica in casa, un amico peloso che emana tranquillità.','14.jpg'),
    ('Cleo','it','Gatto',36,'Femmina',NULL,'Cleo è una gatta tricolore dallo spirito libero e indipendente. Ama godersi i raggi del sole in giardino o sul balcone e osservare la natura. Non è una gatta appiccicosa, ma sa regalare momenti di grande affetto quando è lei a decidere che è il momento delle coccole.','15.jpg'),
    ('Pom','it','Cane',48,'Maschio','Piccolo','Un piccolo leoncino da salotto, soffice e vanitoso. Pom è un Volpino che adora essere al centro dell''attenzione e farsi ammirare. Molto vivace e chiacchierone, è un ottimo compagno di vita e avventure.','16.jpg'),
    ('Iggy','en','Cane',24,'Maschio','Medio','Compatto, muscoloso e con una faccia da fumetto, <span lang="en">Iggy</span> è un Boston Terrier pieno di gioia di vivere. È un cane socievole che va d''accordo con tutti e adora giocare e stare in compagnia. Impossibile sentirsi soli con lui nei paraggi.','17.jpg'),
    ('Simba','it','Gatto',12,'Maschio',NULL,'Una piccola tigre domestica dal manto rosso fuoco. Simba è avventuroso, coraggioso e atletico. Adora arrampicarsi sui tiragraffi più alti e osservare il mondo dall''alto. Ha un carattere solare ed espansivo, tipico dei gatti rossi, ed è sempre pronto a interagire con gli umani.','18.jpg'),
    ('Ombra','it','Gatto',48,'Femmina',NULL,'Con il suo manto grigio vellutato e gli occhi color ambra, Ombra è l''eleganza fatta gatto. È una presenza discreta e silenziosa, quasi mistica. Non ama il caos, ma si lega profondamente a chi sa rispettare i suoi tempi, diventando un''ombra affettuosa che ti segue per casa.','19.jpg');

INSERT INTO 
	Prenotazione (UtenteID, AnimaleID, Data, Note)
VALUES 
    (1, 3, '2026-03-29', 'Prenotazione per visita conoscitiva, spero di trovare un amico dei sogni!'),
    (1, 8, '2026-03-29', 'Purtroppo non ho mai avuto un animale, non so come comportarmi.'),
    (1, 2, '2026-04-01', NULL);

INSERT INTO
	Richiesta_Volontariato (Email, Nome, Cognome, Telefono)
VALUES
	('davide.loparco@studenti.unipd.it','Davide','Loparco','1234567890'),
	('amoicani@gmail.com','Giovanni','Verdi','0987654321');
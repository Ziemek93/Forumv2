
CREATE TABLE Users(
  Id_u INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  Name VARCHAR(45) NOT NULL,
  Login VARCHAR(45) UNIQUE NOT NULL,
  Password VARCHAR(100) NOT NULL,
  Admin INT(1) DEFAULT 0 NOT NULL,
  Sex VARCHAR(45) );
  
CREATE TABLE Sections(
  Id_s INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  sectionTitle TEXT NOT NULL);  

CREATE TABLE Topic(
  Id_t INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  Title VARCHAR(45) NOT NULL,
  TopicContent TEXT NOT NULL ,
  Data DATE NOT NULL,
  topicLink VARCHAR(50) NOT NULL UNIQUE,
  Bool BOOLEAN NOT NULL DEFAULT FALSE,
  Id_sR INT(6) NOT NULL,
  Id_uR INT(6) NOT NULL,
  FOREIGN KEY (Id_sR) REFERENCES Sections (Id_s)
  );

CREATE TABLE Post(
  Id_pc INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  PostContent TEXT NOT NULL ,
  Data DATE NOT NULL,
  Id_tR INT(6),
  Id_uR INT(6),
  FOREIGN KEY (Id_tR) REFERENCES Topic (Id_t)
  );
  
	
  CREATE TABLE Conversation(
  Id_c INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT
  
  );
  
  CREATE TABLE Messages(
  Id_m INT(8) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  MessageContent TEXT,
  Data DATETIME NOT NULL,
   Id_cR INT(8) NOT NULL,
  sentBy INT(6),
  receivedBy INT(6),
  FOREIGN KEY (Id_cR) REFERENCES Conversation (Id_c)

  );
   

CREATE TABLE BAN(
Id_b INT(6) NOT NULL PRIMARY KEY AUTO_INCREMENT,
Id_uR INT(6),
FOREIGN KEY (Id_uR) REFERENCES Users (Id_u)
);

Insert into  Conversation(Id_c) values 
('1');

Insert into  Users(ID_u,Name,Login,Password, Admin, Sex) values 
(NULL,'Maciej','Maciejski','$argon2i$v=19$m=1024,t=2,p=2$SGJyUDJFY2JXM3dIbW81NQ$1NOxHwSkHmuM9xNV5kAu1S5O3OvKBfALIRHFTWoFAI0', DEFAULT,'Mezczyzna'); <--Maciej123 
Insert into  Users(ID_u,Name,Login,Password, Admin,Sex) values 
(NULL,'Krzys','Niekowalski','$argon2i$v=19$m=1024,t=2,p=2$a3NTSFQ4aldadkJlL3ZkLw$JqQe3ud3/LiAMhg1pQTYXsm9X/LNWkay133JEb/0vEY', DEFAULT,'Mezczyzna'); <--maslo123 
Insert into  Users(ID_u,Name,Login,Password, Admin,Sex) values 
(NULL,'Niekrzys','Kowalski','$argon2i$v=19$m=1024,t=2,p=2$MnBWRWt3cWRZNEhoUXRaaQ$cuzI/mw9+qQ3Nrco5bzzvCLO0k1CrZHmKir0o5joYQ4', DEFAULT,'Mezczyzna'); <--kowal123


Insert into  Sections(Id_s ,sectionTitle) values 
(NULL,'Pierwszy dzial');
Insert into  Sections(Id_s ,sectionTitle) values 
(NULL,'drugi dzial');

Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink, Bool,ID_sR, ID_uR) values 
(NULL,'Pierwszy temat','I co mam tutaj napisac',CURDATE(),UUID(), DEFAULT,'1','2');
Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink,  Bool,ID_sR, ID_uR) values 
(NULL,'Drugi temat','nwm',CURDATE(), UUID(), DEFAULT,'1', '1');
Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink,  Bool,ID_sR, ID_uR) values 
(NULL,'Trzeci','Wiec jak dodawac te posty',CURDATE(), UUID(), '1','1', '3');
Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink, Bool,ID_sR, ID_uR) values 
(NULL,'Pierwszy temat','I co mam tutaj napisac',CURDATE(),UUID(), '1','1','1');
Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink,  Bool,ID_sR, ID_uR) values 
(NULL,'Drugi temat','nwm',CURDATE(), UUID(), DEFAULT,'1', '1');
Insert into  Topic(Id_t ,Title,TopicContent,Data, topicLink,  Bool,ID_sR, ID_uR) values 
(NULL,'Trzeci','Wiec jak dodawac te posty',CURDATE(), '6', '1','1', '1');

Insert into  Post(Id_pc ,PostContent,Data, Id_tR, Id_uR) values 
(NULL,'Pierwszy kom', CURDATE(),'1','2');
Insert into  Post(Id_pc ,PostContent,Data, Id_tR, Id_uR) values 
(NULL,'drugi kom', CURDATE(),'1','2');
Insert into  Post(Id_pc ,PostContent,Data, Id_tR, Id_uR) values 
(NULL,'czeci kom', CURDATE(),'1','2');

Insert into  Messages(Id_m ,MessageContent, Data, Id_cR, sentBy, receivedBy) values 
(NULL,'dsadasdzzzzzzzzzzzzzzzasdasdasdasd', '2000-11-29 12:58:28', '1','1','2');
Insert into  Messages(Id_m ,MessageContent,Data,Id_cR, sentBy, receivedBy) values 
(NULL,'dsadasdasdddasd','2012-11-29 12:58:28', '1','2','1');
Insert into  Messages(Id_m ,MessageContent,Data,Id_cR, sentBy, receivedBy) values 
(NULL,'dsadaggsdasdasd', '2014-11-29 12:58:28', '1','1','2');
Insert into  Messages(Id_m ,MessageContent,Data,Id_cR, sentBy, receivedBy) values 
(NULL,'dsadaqqsdasdasd', '2016-11-29 12:58:28', '1','2','1');

Insert into  Ban(ID_B, Id_uR) values 
(NULL,'2');


 
/*
 ==========================================================
 |                     -- Drops --                        |
 ==========================================================
 
 */
DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Role;
DROP TABLE IF EXISTS Status;
DROP TABLE IF EXISTS Message;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Ticket_User;
DROP TABLE IF EXISTS User_Department;
DROP TABLE IF EXISTS FAQ;
DROP TABLE IF EXISTS Ticket_Files;
DROP TABLE IF EXISTS Ticket_History;
DROP TABLE IF EXISTS Message_Files;
/*
 
 ==========================================================
 |                     -- Tabelas --                      |
 ==========================================================
 
 */
-- Tabela de Usuários
CREATE TABLE User (
  id INTEGER PRIMARY KEY AUTOINCREMENT,
  fullname VARCHAR(255) NOT NULL,
  username VARCHAR(255) UNIQUE NOT NULL,
  email VARCHAR(255) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role_id INTEGER NOT NULL,
  image_path VARCHAR(255),
  CONSTRAINT user_role_fk FOREIGN KEY (role_id) REFERENCES Role ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de Tickets
CREATE TABLE Ticket (
  id INTEGER PRIMARY KEY,
  subject VARCHAR(255) NOT NULL,
  description TEXT,
  datetime DATETIME NOT NULL,
  department VARCHAR(255),
  status_id INTEGER NOT NULL,
  CONSTRAINT ticket_status_fk FOREIGN KEY (status_id) REFERENCES Status ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de Roles, ex: Admin, Client, Agent
CREATE TABLE Role (
  id INTEGER,
  sigla VARCHAR(3) NOT NULL,
  CONSTRAINT role_pk PRIMARY KEY (id)
);
-- Tabela de Status, ex: Open, Closed
CREATE TABLE Status (
  id INTEGER,
  stat VARCHAR(50) NOT NULL,
  CONSTRAINT status_pk PRIMARY KEY (id)
);
-- Tabela de Mensagens, mensagens trocadas entre o usuário e o agente
CREATE TABLE Message (
  id INTEGER,
  text TEXT NOT NULL,
  datetime DATETIME,
  user_id INTEGER NOT NULL,
  ticket_id INTEGER NOT NULL,
  CONSTRAINT message_pk PRIMARY KEY (id),
  CONSTRAINT message_user_fk FOREIGN KEY (user_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT message_ticket_fk FOREIGN KEY (ticket_id) REFERENCES Ticket ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de Departamentos, relaciona os usuários com os departamentos
CREATE TABLE Department (
  id INTEGER,
  name VARCHAR(50) NOT NULL,
  CONSTRAINT department_pk PRIMARY KEY (id)
);
-- Tabela de Hashtag, relaciona as hashtags com os tickets
CREATE TABLE Hashtag (
  id INTEGER,
  name VARCHAR(50) NOT NULL,
  ticket_id INTEGER,
  CONSTRAINT hashtag_pk PRIMARY KEY (id),
  CONSTRAINT hashtag_ticket_fk FOREIGN KEY (ticket_id) REFERENCES Ticket ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela Ticket_User, relaciona os usuários com os tickets
CREATE TABLE Ticket_User (
  ticket_id INTEGER PRIMARY KEY,
  client_id INTEGER,
  agent_id INTEGER,
  CONSTRAINT ticket_user_pk UNIQUE (client_id, ticket_id),
  CONSTRAINT ticket_user_user_fk FOREIGN KEY (client_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT ticket_user_agent_fk FOREIGN KEY (agent_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT ticket_user_ticket_fk FOREIGN KEY (ticket_id) REFERENCES Ticket ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de User_Department, relaciona os usuários com os departamentos
CREATE TABLE User_Department (
  user_id INTEGER NOT NULL,
  department_id INTEGER NOT NULL,
  CONSTRAINT user_department_pk UNIQUE (user_id, department_id),
  CONSTRAINT user_department_user_fk FOREIGN KEY (user_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT user_department_department_fk FOREIGN KEY (department_id) REFERENCES Department ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de FAQ, perguntas frequentes feitas pelos clientes e respondidas pelos agentes
CREATE TABLE FAQ (
  id INTEGER,
  question VARCHAR(255) NOT NULL,
  answer TEXT NOT NULL,
  user_id INTEGER NOT NULL,
  CONSTRAINT faq_pk PRIMARY KEY (id),
  CONSTRAINT faq_user_fk FOREIGN KEY (user_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de Ticket Files, relaciona os tickets com os arquivos anexados e seus respectivos usuários
CREATE TABLE Ticket_Files (
  id INTEGER,
  file_path VARCHAR(255) NOT NULL,
  user_id INTEGER NOT NULL,
  ticket_id INTEGER NOT NULL,
  CONSTRAINT ticket_files_pk PRIMARY KEY (id),
  CONSTRAINT ticket_files_user_fk FOREIGN KEY (user_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT ticket_files_ticket_fk FOREIGN KEY (ticket_id) REFERENCES Ticket ON UPDATE CASCADE ON DELETE CASCADE
);

-- Tabela de Ticket Files, relaciona os tickets com os arquivos anexados e seus respectivos usuários
CREATE TABLE Ticket_History (
  id INTEGER,
  updates VARCHAR(255) NOT NULL,
  ticket_id INTEGER NOT NULL,
  CONSTRAINT ticket_history_pk PRIMARY KEY (id),
  CONSTRAINT ticket_history_ticket_fk FOREIGN KEY (ticket_id) REFERENCES Ticket ON UPDATE CASCADE ON DELETE CASCADE
);
-- Tabela de Message Files, relaciona as mensagens com os arquivos anexados e seus respectivos usuários
CREATE TABLE Message_Files (
  id INTEGER,
  file_path VARCHAR(255) NOT NULL,
  user_id INTEGER NOT NULL,
  message_id INTEGER NOT NULL,
  CONSTRAINT message_files_pk PRIMARY KEY (id),
  CONSTRAINT message_files_user_fk FOREIGN KEY (user_id) REFERENCES User ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT message_files_message_fk FOREIGN KEY (message_id) REFERENCES Message ON UPDATE CASCADE ON DELETE CASCADE
);
/*
 
 ==========================================================
 |                     -- Inserts --                      |
 ==========================================================
 
 */
-- Insert de Roles
INSERT INTO Role
VALUES (1, 'ADM');
INSERT INTO Role
VALUES (2, 'AGE');
INSERT INTO Role
VALUES (3, 'CLI');
-- Insert de Status
INSERT INTO Status
VALUES (1, 'Open');
INSERT INTO Status
VALUES (2, 'Assigned');
INSERT INTO Status
VALUES (3, 'Closed');
-- Insert de Departamentos
INSERT INTO Department
VALUES (1, 'General');
INSERT INTO Department
VALUES (2, 'Packaging');
INSERT INTO Department
VALUES (3, 'Payment');
INSERT INTO Department
VALUES (4, 'Delivery');

-- Insert de Hashtags
-- Id, name, ticket_id
INSERT INTO Hashtag
VALUES (1, '#Urgent', 2);
INSERT INTO Hashtag
VALUES (2, '#Priority', 3);
INSERT INTO Hashtag
VALUES (3, '#Important', 1);
INSERT INTO Hashtag
VALUES (4, '#Common', 4);
INSERT INTO Hashtag
VALUES (5, '#Doubt', 5);
INSERT INTO Hashtag
VALUES (6, '#VIP', 7);
INSERT INTO Hashtag
VALUES (7, '#LifeOrDeath', 6);
INSERT INTO Hashtag
VALUES (8, '#NotImportant', 8);
INSERT INTO Hashtag
VALUES (9, '#General', 10);
INSERT INTO Hashtag
VALUES (10, '#Packaging', 9);

-- Insert de User_department
-- Id, user_id, department_id
INSERT INTO User_Department
VALUES (4, 1);
INSERT INTO User_Department
VALUES (4, 2);
INSERT INTO User_Department
VALUES (4, 3);
INSERT INTO User_Department
VALUES (5, 4);
INSERT INTO User_Department
VALUES (5, 3);
INSERT INTO User_Department
VALUES (5, 2);
INSERT INTO User_Department
VALUES (6, 1);
Insert INTO User_Department
VALUES (6, 4);
INSERT INTO User_Department
VALUES (7, 2);
INSERT INTO User_Department
VALUES (7, 3);
INSERT INTO User_Department
VALUES (8, 3);
INSERT INTO User_Department
VALUES (8, 4);
INSERT INTO User_Department
VALUES (9, 4);
INSERT INTO User_Department
VALUES (9, 3);
INSERT INTO User_Department
VALUES (5, 1);


-- Insert de Tickets
-- Id, subject, description, datetime, department, status_id
INSERT INTO Ticket
VALUES (1, 'Problem with delivery', 'Delivery boy dropped the box', '10-05-2023 10:00', 'Delivery', 2);
INSERT INTO Ticket
VALUES (2, 'Could not access the website', 'I can not access the website', '10-11-2020 10:00', 'General', 3);
INSERT INTO Ticket
VALUES (3, 'Problem with payment', 'I can not pay', '20-05-2023 14:23', 'Payment', 2);
INSERT INTO Ticket
VALUES (4, 'Problem with packaging', 'The box is damaged', '20-04-2023 11:25', 'Packaging', 2);
INSERT INTO Ticket
VALUES (5, 'Doubt', 'I have a doubt, which one should I choose?', '11-03-2023 18:54', 'General', 3);
INSERT INTO Ticket
VALUES (6, 'Changing Address', 'I gave the wrong address while ordering and want to change it', '20-05-2023 18:55', 'Delivery', 1);
INSERT INTO Ticket
VALUES (7, 'VIP', 'I am a VIP and want to know if I can get a discount', '17-05-2023 15:51', 'General', 2);
INSERT INTO Ticket
VALUES (8, 'Doubt about causing hangovers', 'I have a doubt, which is better for avoiding hangovers?', '28-02-2023 11:00', 'General', 3);
INSERT INTO Ticket
VALUES (9, 'How can I tell if my wine is corked?', 'After opening and smelling the wine, I think it is corked, how can I be sure?', '18-05-2023 11:00', 'Packaging', 2);
INSERT INTO Ticket
VALUES (10, 'Prices', 'Is there anyway I could buy larger quantities at a smaller price?', '20-05-2023 13:25', 'General', 2);



-- Insert de Ticket_User
-- Clients = IDs de 10 a 19
-- Agents = IDs de 4 a 9
INSERT INTO Ticket_User
VALUES (1, 12, 5);
INSERT INTO Ticket_User
VALUES (2, 13, 6);
INSERT INTO Ticket_User
VALUES (3, 14, 8);
INSERT INTO Ticket_User
VALUES (4, 15, 7);
INSERT INTO Ticket_User
VALUES (5, 16, 4);
INSERT INTO Ticket_User
VALUES (7, 18, 4);
INSERT INTO Ticket_User
VALUES (8, 19, 5);
INSERT INTO Ticket_User
VALUES (9, 10, 7);
INSERT INTO Ticket_User
VALUES (10, 11, 6);

-- Insert de Ticket_Files
--Id, file_path, user_id, ticket_id
INSERT INTO Ticket_Files
VALUES (1, 'garrafa_partida.png', 12, 1);
INSERT INTO Ticket_Files
VALUES (2, 'caixa_rebentada.png', 15, 4);
INSERT INTO Ticket_Files
VALUES (3, 'melhor.png', 16, 5);
INSERT INTO Ticket_Files
VALUES (4, 'VIP.png', 18, 7);
INSERT INTO Ticket_Files
VALUES (5, 'melhor.png', 19, 8);
INSERT INTO Ticket_Files
VALUES (6, 'cork.png', 10, 9);



-- Insert de Ticket_History
--Id, updates, ticket_id
INSERT INTO Ticket_History
VALUES (1, '10-05-2023 10:00 - Ticket was created', 1);
INSERT INTO Ticket_History
VALUES (2, '10-05-2023 10:02 - Assigned to AgentMota', 1);
INSERT INTO Ticket_History
VALUES (3, '10-11-2022 10:00 - Ticket was created', 2);
INSERT INTO Ticket_History
VALUES (4, '10-11-2022 10:01 - Assigned to AgentLandolt', 2);
INSERT INTO Ticket_History
VALUES (5, '10-11-2022 10:33 - Changed status to Closed', 2);
INSERT INTO Ticket_History
VALUES (6, '20-05-2023 14:23 - Ticket was created', 3);
INSERT INTO Ticket_History
VALUES (22, '20-05-2023 14:25 - Assigned to AgentLima', 3);
INSERT INTO Ticket_History
VALUES (7, '20-04-2023 11:25 - Ticket was created', 4);
INSERT INTO Ticket_History
VALUES (8, '20-04-2023 11:28 - Assigned to AgentCoelho', 4);
INSERT INTO Ticket_History
VALUES (9, '11-03-2023 18:54 - Ticket was created', 5);
INSERT INTO Ticket_History
VALUES (10, '11-03-2023 18:55 - Assigned to agent1', 5);
INSERT INTO Ticket_History
VALUES (11, '12-03-2023 8:38 - Changed status to Closed', 5);
INSERT INTO Ticket_History
VALUES (12, '20-05-2023 18:55 - Ticket was created', 6);
INSERT INTO Ticket_History
VALUES (13, '17-05-2023 15:51 - Ticket was created', 7);
INSERT INTO Ticket_History
VALUES (14, '17-05-2023 15:53 - Assigned to agent1', 7);
INSERT INTO Ticket_History
VALUES (15, '28-02-2023 11:00 - Ticket was created', 8);
INSERT INTO Ticket_History
VALUES (16, '28-02-2023 11:02 - Assigned to AgentMota', 8);
INSERT INTO Ticket_History
VALUES (17, '28-02-2023 11:05 - Changed status to closed', 8);
INSERT INTO Ticket_History
VALUES (18, '18-05-2023 11:00 - Ticket was created', 9);
INSERT INTO Ticket_History
VALUES (21, '18-05-2023 11:02 - Assigned to AgentCoelho', 9);
INSERT INTO Ticket_History
VALUES (19, '20-05-2023 13:25 - Ticket was created', 10);
INSERT INTO Ticket_History
VALUES (20, '20-05-2023 13:26 - Assigned to AgentLandolt', 10);

-- Insert de Messages
--Id, text, datetime, user_id, ticket_id
INSERT INTO Message
VALUES (1, 'Hello there, I am your assigned agent, how may I help you?', '10-05-2023 10:03', 5, 1);
INSERT INTO Message
VALUES (2, 'Saw the delivery boy drop the box when he arrived, attachment contains a pic of the result.', '10-05-2023 10:15', 12, 1);
INSERT INTO Message
VALUES (3, 'Thank you for your feedback, we will handle it from here.', '10-05-2023 10:23', 5, 1);
INSERT INTO Message
VALUES (4, 'Hello there, I am your assigned agent, how may I help you?', '10-11-2022 10:05', 6, 2);
INSERT INTO Message
VALUES (5, 'I can not access the website', '10-11-2022 10:18', 13, 2);
INSERT INTO Message
VALUES (6, 'Thank you for your feedback, we will handle it from here.', '10-11-2022 10:23', 6, 2);
INSERT INTO Message
VALUES (7, 'It has been fixed', '10-11-2022 10:33', 6, 2);
INSERT INTO Message
VALUES (8, 'Hello there, I am your assigned agent, can you provide more info about the box?', '20-05-2023 14:25', 7, 4);
INSERT INTO Message
VALUES (9, 'The box is heavily damaged, it looks like it has been rained on', '20-05-2023 14:27', 15, 4);
INSERT INTO Message
VALUES (10, 'Thank you for your feedback, we will handle it from here.', '20-05-2023 14:30', 7, 4);
INSERT INTO Message
VALUES (11, 'Hello there, the best depends on your wine preferences, can you tell me a bit about them?', '11-03-2023 18:56', 4, 5);
INSERT INTO Message
VALUES (12, 'I like red wine, but I am open to trying new things', '12-03-2023 01:35', 16, 5);
INSERT INTO Message
VALUES (13, 'I recommend Alvarinho, then.', '12-03-2023 08:37', 4, 5);
INSERT INTO Message
VALUES (14, 'Hello there, I will take a look at your level of fame and get back to you', '17-05-2023 18:56', 4, 7);
INSERT INTO Message
VALUES (15, 'Make it fast, I am very important.', '18-05-2023 14:31', 18, 7);
INSERT INTO Message
VALUES (16, 'Hello there, I would definitely recommend the "Branco Grande Escolha" if you do not want to drink a wine with too much alcohol', '28-02-2023 11:05', 5, 8);
INSERT INTO Message
VALUES (17, 'Hello there, I will ask my superiors and get back to you', '15-05-2023 13:25', 6, 10);
INSERT INTO Message
VALUES (18, 'OK, thank you', '15-05-2023 18:25', 11, 10);



-- Insert de FAQs
--Id, question, answer, user_id
INSERT INTO FAQ
VALUES (1, 'How do I know if my wine is corked?', 'If you notice a musty smell or a damp cardboard taste, your wine is probably corked. This is caused by a chemical compound called TCA, which can be found in cork. If you suspect that your wine is corked, you can send it to us for testing. We will determine whether or not it is corked and provide you with a replacement bottle if necessary.', 1);
INSERT INTO FAQ
VALUES (2, 'What is the best way to store wine?', 'The best way to store wine is in a cool, dark place. This will help preserve the flavor and prevent it from spoiling. If you don not have a cellar or basement, you can store your wine in the refrigerator. Just make sure that it is not too cold or too hot!', 1);
INSERT INTO FAQ
VALUES (3, 'What is the best way to open a bottle of wine?', 'The best way to open a bottle of wine is by using a corkscrew. This will ensure that the cork does not break and that you do not spill any wine. If you do not have a corkscrew, you can use a knife or scissors to cut the foil off the top of the bottle. Then, insert the tip of the knife into the cork and twist it until it comes out. Finally, pour yourself a glass and enjoy!', 1);
INSERT INTO FAQ
VALUES (4, 'What is the best cork for wine?', 'The best cork for wine is a natural cork. This type of cork is made from the bark of the cork oak tree and has been used for centuries. It is also biodegradable, which means that it can be recycled or composted after use. Natural corks are more expensive than synthetic corks, but they are worth it because they do not affect the taste of your wine!', 1);
INSERT INTO FAQ
VALUES (5, 'How can I submit a ticket', 'Select "Submit a Ticket" and insert the required information and attachments' , 1);
INSERT INTO FAQ
VALUES (6, 'How can I check my tickets', 'Select "My Tickets" and you will be able to see all your tickets', 1);
INSERT INTO FAQ
VALUES (7, 'What types of wine problems can I submit a ticket for?', 'You can submit a ticket for a wide range of wine problems, including but not limited to damaged bottles, cork taint, off-flavors or aromas, cloudiness or sediment, leaking bottles, incorrect labeling, or any other quality-related issues, as well as payment and delivery problems.', 1);
INSERT INTO FAQ
VALUES (8, 'How long does it usually take to receive a response to my ticket?', 'We strive to respond to tickets as quickly as possible. Typically, you can expect to receive a response within 24 to 48 hours (excluding weekends and holidays). In cases of high volume or more complex issues, it may take slightly longer.', 1);
INSERT INTO FAQ
VALUES (9, 'What should I do if I received a damaged bottle of wine?', 'If you received a damaged bottle of wine, please take photos of the damaged packaging and bottle before opening it. Submit a ticket immediately, providing the necessary details and attaching the photos. We will assist you in resolving the issue promptly.', 1);
INSERT INTO FAQ
VALUES (10, 'Are there any specific requirements for submitting a ticket related to wine quality?', 'While there are no strict requirements, it is helpful to provide as much detail as possible about the wine quality issue. Describing the specific problem, including any relevant observations or tasting notes, will assist us in better understanding and addressing your concern.',1);
INSERT INTO FAQ
VALUES (11, 'Can I submit a ticket if I have a general question about wine?', 'Absolutely! If you have a general question about wine, our customer support team is available to provide guidance and information. Feel free to submit a ticket with your inquiry, and we will be happy to assist you.', 1);
INSERT INTO FAQ
VALUES (12, 'Is there a limit to the number of tickets I can submit?', 'There is no set limit to the number of tickets you can submit. However, we encourage you to consolidate your concerns whenever possible to ensure efficient handling of your requests.', 1);
INSERT INTO FAQ
VALUES (13, 'Will my personal information be kept confidential when I submit a ticket?', 'Yes, we take your privacy seriously. Your personal information will be kept confidential and will only be used for the purpose of addressing your wine problem. We adhere to strict privacy policies and safeguards to ensure the protection of your information.', 1);


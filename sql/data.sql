#Cleaning up the available data before inserting all of this. This also resets AUTO_INCREMENT values.

#truncatable tables
TRUNCATE TABLE system_config;
TRUNCATE TABLE organizations;
TRUNCATE TABLE debit_details;
TRUNCATE TABLE event_content;
TRUNCATE TABLE group_content;
TRUNCATE TABLE event_participants;
TRUNCATE TABLE group_participants;
TRUNCATE TABLE requests;
TRUNCATE TABLE content_comments;
TRUNCATE TABLE messages;


#non-truncatable tables
DELETE FROM user_groups;
ALTER TABLE user_groups AUTO_INCREMENT = 1;

DELETE FROM content;
ALTER TABLE content AUTO_INCREMENT = 1;

DELETE FROM events;
ALTER TABLE events AUTO_INCREMENT = 1;

DELETE FROM users;
ALTER TABLE users AUTO_INCREMENT = 1;

DELETE FROM roles;
ALTER TABLE roles AUTO_INCREMENT = 1;



#Data insertion
#System Config
INSERT INTO system_config (charge_rate) VALUES 
(1.00),
(10.00),
(100.00),
(1000.00),
(10000.00),
(100000.00),
(1000000.00);


#Roles
INSERT INTO roles (user_role, auth_lvl) VALUES
('sysadmin', 0),
('controller', 1),
('event_manager', 2),
('group_manager', 3),
('participant', 4);

#Users
#default password is password, for convenience
INSERT INTO users (role_id, username, user_password, email, first_name, last_name, adr_number, street, city, dob) VALUES
#sysadmin
(1, 'pepe','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email0@service.com', 'Pepe', 'Pepeson', '1', 'Straight Lane', 'Someville', '1990-11-11'),

#controller
(2,'whoareu','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email1@service.com', 'Alice', 'Alison', '1', 'Straight Lane', 'Someville', '1990-11-11'),

#event managers
(3, 'guile','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email2@service.com', 'Mark', 'Markson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(3, 'akuma','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email3@service.com', 'Luke', 'Lukeson', '1', 'Straight Lane', 'Someville', '1990-11-11'),

#group managers
(4, 'kage','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email4@service.com', 'Jerri', 'Jerrison', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(4, 'axl','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email5@service.com', 'Booker', 'Bookerson', '1', 'Straight Lane', 'Someville','1990-11-11'),
(4, 'el gado','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email6@service.com', 'Carlton', 'Carltonson', '1', 'Straight Lane', 'Someville','1990-11-11'),
(4, 'eden','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email7@service.com', 'Carl', 'Carlson', '1', 'Straight Lane', 'Someville', '1990-11-11'),

#users
(5, 'celeste','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email8@service.com', 'Conor', 'Conorson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'geki','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email9@service.com', 'Loren', 'Lorenson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'gill','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email10@service.com', 'Alecia', 'Aleciason', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'hakan','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email11@service.com', 'Hugh', 'Hughson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'hokuto','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email12@service.com', 'Brant', 'Brantson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'cammy','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email13@service.com', 'Hiram', 'Hiramson', '1', 'Straight Lane', 'Someville', '1990-11-11'),
(5, 'ryu','5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8', 'email14@service.com', 'Haley', 'Haleson', '1', 'Straight Lane', 'Someville', '1990-11-11');

#Debit details for event managers
INSERT INTO debit_details(user_id, bank_num, account_code ) VALUES
(3, 123456, 12345678),
(4, 987654, 98765432);

#Organizations for event managers
INSERT INTO organizations(user_id, org_name, org_type ) VALUES
(3, "Organization 1", "Family"),
(4, "Organization 2", "Corporation");

#Events
INSERT INTO events (manager_id, event_name, event_status, fee, event_description, lifetime) VALUES
(3, 'Event 1', true, 10, 'The first event', '2019-11-30 16:00:00'),
(3, 'Event 2', true, 10, 'The second event', '2019-11-30 16:00:00'),
(3, 'Event 3', true, 10, 'The third event', '2019-11-30 16:00:00'),
(4, 'Event 4', true, 10, 'The fourth event', '2019-11-30 16:00:00'),
(4, 'Event 5', true, 10, 'The fifth event', '2019-12-30 16:00:00'),
(4, 'Event 6', true, 10, 'The sixth event', '2019-12-30 16:00:00'),
(3, 'Event 7', true, 10, 'The seventh event', '2019-12-30 16:00:00'),
(3, 'Event 8', true, 10, 'The eigth event', '2020-01-30 16:00:00'),
(4, 'Event 9', true, 10, 'The ninth event', '2020-03-30 16:00:00'),
(3, 'Event 10', true, 10, 'The tenth event', '2020-03-30 16:00:00');


#user_groups
INSERT INTO user_groups (event_id, manager_id, group_name, group_description) VALUES
(1, 5, 'Group 1', 'The first group'),
(1, 6, 'Group 2', 'The second group'),
(2, 7, 'Group 3', 'The third group'),
(3, 8, 'Group 4', 'The fourth group'),
(4, 5, 'Group 5', 'The fifth group'),
(4, 6, 'Group 6', 'The sixth group'),
(5, 7, 'Group 7', 'The seventh group'),
(6, 8, 'Group 8', 'The eigth group'),
(6, 8, 'Group 9', 'The ninth group'),
(6, 8, 'Group 10', 'The tenth group');


#Event Participants
INSERT INTO event_participants (user_id, event_id) VALUES
(9,1),
(10,1),
(11,1),
(12,1),
(5,1),
(6,1),
(10,2),
(7,2),
(9,3),
(8,3),
(10,4),
(11,4),
(12,4),
(5,4),
(6,4),
(7,5),
(8,6),
(3,3),
(3,5),
(4,1),
(4,4);

#Group Participants
INSERT INTO group_participants (user_id, group_id) VALUES
(9,1),
(10,1),
(11,1),
(12,2),
(12,1),
(10,3),
(9,4),
(10,5),
(11,6),
(12,6),
(5,1),
(6,2),
(7,3),
(8,4),
(5,5),
(6,6),
(7,7),
(8,8),
(3,4),
(3,7),
(4,2),
(4,6);

#Insert content with random dates
INSERT INTO content (user_id, type, content, post_time) VALUES
(9,0, "Lorem ipsum dolor sit amet, consectetur adipiscing elit.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(10,0, "Nulla fringilla a ante posuere ornare.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(11,0, "Vivamus malesuada vitae quam ullamcorper ultrices. Phasellus tempor metus sed pharetra commodo.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(12,0, "Duis viverra nulla tellus, vitae lobortis enim ultrices in. Mauris pulvinar consectetur ipsum, ut rutrum massa condimentum et.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(10,0, "Vestibulum dignissim eget nisi venenatis blandit.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),

(6,0, "In leo felis, placerat sit amet massa et, sagittis volutpat tortor.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(7,0, "Morbi et quam lectus.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(8,0, "Pellentesque aliquam nec tortor sit amet tincidunt.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(5,0, "Cras ultricies lectus vel massa molestie, et molestie odio ornare.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(6,0, "Nullam non dolor dignissim, convallis lorem in, congue purus.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),

(7,0, "Donec ut urna volutpat, facilisis urna eget, accumsan odio.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(10,0, "Donec finibus lobortis lacinia.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY),
(11,0, "Nam id mauris est.", CURRENT_TIMESTAMP - INTERVAL FLOOR(RAND() * 14) DAY);


#Linking content to user_groups
INSERT INTO group_content (group_id, content_id) VALUES
(1,1),
(2,4),
(3,2),
(4,8),
(5,9),
(3,11),
(6,13);

#Linking content to events
INSERT INTO event_content (event_id, content_id) VALUES
(1,3),
(1,5),
(4,6),
(2,7),
(1,10),
(5,11);

#Comments
INSERT INTO content_comments(content_id, user_id, comment_text, post_time) VALUES
(1,5,"Donec hendrerit blandit leo, quis cursus augue vulputate a.", CURRENT_TIMESTAMP),
(1,10, "Maecenas sit amet hendrerit orci.", CURRENT_TIMESTAMP + INTERVAL 1 HOUR),
(1,11, "Phasellus dignissim arcu id efficitur luctus.", CURRENT_TIMESTAMP + INTERVAL 2 HOUR),
(2,7, "Suspendisse non pellentesque enim.", CURRENT_TIMESTAMP),
(3,5, "Vivamus a arcu nec mauris auctor tristique.", CURRENT_TIMESTAMP),

(5,12, "Duis rutrum quis risus pulvinar facilisis.", CURRENT_TIMESTAMP),
(6,6, "Vivamus ut egestas ligula, non lobortis velit.", CURRENT_TIMESTAMP),
(6,11, "Donec bibendum ut mauris vel ullamcorper.", CURRENT_TIMESTAMP+ INTERVAL 2 HOUR),
(4,6, "Nullam euismod cursus dui, eget aliquet mi accumsan ac.", CURRENT_TIMESTAMP),
(8,8, "Proin rutrum diam quis bibendum tempor.", CURRENT_TIMESTAMP);

#Messages
INSERT INTO messages(source_id, dest_id, message_text, sent_time) VALUES
(10,1, "Nulla faucibus felis ligula, quis vulputate justo iaculis at.", CURRENT_TIMESTAMP),
(11,1, "Pellentesque scelerisque, leo eget condimentum vulputate, turpis velit venenatis sem, quis vehicula ante magna in nulla.", CURRENT_TIMESTAMP + INTERVAL 1 HOUR),
(12,1, "Morbi eget iaculis risus.", CURRENT_TIMESTAMP + INTERVAL 2 HOUR),
(1,7, "Suspendisse potenti. Proin hendrerit ipsum sed erat vehicula scelerisque.", CURRENT_TIMESTAMP + INTERVAL 3 HOUR),
(2,6, "Nulla tincidunt blandit dui at fermentum.", CURRENT_TIMESTAMP),
(3,5, "Vestibulum imperdiet nisl ac est sollicitudin, et tincidunt mi congue.", CURRENT_TIMESTAMP),
(4,4, "Vivamus vel ex tristique, pretium felis vitae, tempor felis.", CURRENT_TIMESTAMP),
(5,3, "Nullam suscipit lobortis blandit. ", CURRENT_TIMESTAMP),
(6,2, "Phasellus vel ex sed erat ultrices auctor.", CURRENT_TIMESTAMP),
(7,8, "In iaculis dolor ante, vitae bibendum lectus ultrices tincidunt.", CURRENT_TIMESTAMP);

#Requests
INSERT INTO requests(source_id, dest_id, group_id, request_type, request_status ) VALUES
(5,6,1, "invite",0),
(6,9,2, "invite",0),
(7,11,3, "invite",0),
(8,13,4, "invite",0),
(8,14,4, "invite",0),

(15,8,4, "join",0),
(14,7,3, "join",0),
(13,6,2, "join",0),
(15,6,2, "join",0),
(11,6,2, "join",0);
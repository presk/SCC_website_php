--CREATE A USER
INSERT INTO users (role_id, username, user_password, email, first_name, last_name, 
		   adr_number, street, city, dob)
VALUES ($roleID, $userName, $userPass, $email, $firstName, $lastName, 
        $adr_number, $street, $city, $bday);

--DELETE A USER
DELETE FROM users
WHERE id = $id;

--EDIT A USER
--User can edit any column except IDs and then we set the updates in php using setters and update all variables in mysql (whatever didn't change will just stay the same)
UPDATE users
SET username = $userName, user_password = $userPass, email= $email, first_name = $firstName, last_name = $lastName, adr_number = $adr_number, street = $street, city = $city, dob = $bday
WHERE id = $id;

--DISPLAY A USER
--Display by ID, username, or FULL name
SELECT * FROM users
WHERE (id = id OR username = $username 
	       OR (first_name = $first_name AND last_name = $last_name));

--CREATE A GROUP
INSERT INTO groups (event_id, manager_id, group_name, group_description)
VALUES ($event_id, $manager_id, $name, $description);

--DELETE A GROUP
DELETE FROM groups
WHERE (id = $id);

--EDIT A GROUP
--User can edit any column except IDs and then we set the updates in php using setters and update all variables in mysql (whatever didn't change will just stay the same)
UPDATE groups 
SET group_name = $name, group_description = $description
WHERE id = $id;

--DISPLAY A GROUP
--Display by ID, name, or any string that matches part of the descritpion
SELECT * FROM groups 
WHERE (id = $id OR name = $name OR description LIKE '%$description%');

--CREATE A LIST OF MEMBERS IN A GROUP

--DELETE A LIST OF MEMBERS IN A GROUP

--EDIT A LIST OF MEMBERS IN A GROUP

--DISPLAY A LIST OF MEMBERS IN A GROUP

--REQUEST TO JOIN A GROUP IN THE EVENT
--Assumption is this is requested by a user object (ie. $id is the user's ID)
--$mgrOfGroup - get ID of the group manager
INSERT INTO requests (source_id, dest_id, group_id, request_type, request_status)
VALUES ($id, $mgrOfGroup, $groupID, $type, false);

--WITHDRAW FROM A GROUP
--Assumption is this is done by a user object (ie. $id is the user's ID)
DELETE FROM group_participants
WHERE id = $id;

--POST TEXTS, IMAGES, OR VIDEOS
--Assumption is this is done by a user object (ie. $id is the user's ID)

--First insert into content table
INSERT INTO content (user_id, type, content, post_time)
VALUES ($id, $type, $content, $post_time);

--Insert into group_content

--Insert into event_content


--VIEW POSTS BY OTHER MEMBERS
--Assumption is this is done by a user object (ie. $id is the user's ID)

--Group
SELECT content, post_time 
FROM content c 
INNER JOIN group_content gc
ON c.id = gc.content_id
INNER JOIN group_participants gp
ON gc.group_id = gp.group_id
WHERE gp.user_id = $id;

--Event
SELECT content, post_time 
FROM content c 
INNER JOIN event_content ec
ON c.id = ec.content_id
INNER JOIN event_participants ep
ON ec.group_id = ep.group_id
WHERE ep.user_id = $id;

--COMMENT ON POSTS
--Assumption is this is done by a user object (ie. $id is the user's ID)

INSERT INTO content_comments (content_id, user_id, text)
VALUES ($group_contentID, $id, $text);

--VIEW COMMENTS ON POSTS
--Assumption is this is done by a user object (ie. $id is the user's ID)

SELECT text
FROM content_comments cc
INNER JOIN group_content gc
ON cc.content_id = gc.content_id
WHERE gc.content_id = $content_id;



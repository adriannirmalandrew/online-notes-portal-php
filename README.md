# Project Information

##online-notes-portal-php

An online portal for uploading notes and other lecture material, written in PHP.

SQL Schema:

    MariaDB [sw_engg_project]> describe faculty;
    +------------+--------------+------+-----+---------+-------+
    | Field      | Type         | Null | Key | Default | Extra |
    +------------+--------------+------+-----+---------+-------+
    | faculty_id | varchar(50)  | NO   | PRI | NULL    |       |
    | name       | varchar(200) | YES  |     | NULL    |       |
    | school     | varchar(10)  | YES  |     | NULL    |       |
    +------------+--------------+------+-----+---------+-------+

    MariaDB [sw_engg_project]> describe login;
    +---------------+--------------+------+-----+---------+-------+
    | Field         | Type         | Null | Key | Default | Extra |
    +---------------+--------------+------+-----+---------+-------+
    | faculty_id    | varchar(50)  | NO   | PRI | NULL    |       |
    | password_hash | varchar(100) | YES  |     | NULL    |       |
    | session_id    | varchar(100) | YES  |     | NULL    |       |
    +---------------+--------------+------+-----+---------+-------+

    MariaDB [sw_engg_project]> describe posts;
    +------------+--------------+------+-----+---------+-------+
    | Field      | Type         | Null | Key | Default | Extra |
    +------------+--------------+------+-----+---------+-------+
    | post_id    | varchar(100) | NO   | PRI | NULL    |       |
    | faculty_id | varchar(50)  | YES  | MUL | NULL    |       |
    | course_code| varchar(10)  | YES  |     | NULL    |       |
    | title      | varchar(200) | YES  |     | NULL    |       |
    | media_type | varchar(10)  | YES  |     | NULL    |       |
    +------------+--------------+------+-----+---------+-------+

Post content must be stored in plaintext format, in the /posts directory. Each file must have the same name as the post_id it corresponds to. The following media types are valid:

-IMAGE

-VIDEO

-TEXT

-RAW

The show\_posts.php page will be displayed according to the media\_type for the post.

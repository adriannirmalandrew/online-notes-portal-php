# project_3001
My CSE3001 (Software Engineering) Project

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
    | faculty_id | varchar(50)  | YES  |     | NULL    |       |
    | title      | varchar(200) | YES  |     | NULL    |       |
    +------------+--------------+------+-----+---------+-------+

CREATE DATABASE ASR;
USE ASR;
CREATE TABLE faculty_login ( username VARCHAR(100) NOT NULL PRIMARY KEY, password VARCHAR(255) NOT NULL );
CREATE TABLE student_login ( username VARCHAR(100) NOT NULL PRIMARY KEY, password VARCHAR(255) NOT NULL );
CREATE TABLE admin_login ( username VARCHAR(100) NOT NULL PRIMARY KEY, password VARCHAR(255) NOT NULL );
CREATE TABLE tests ( faculty_id INT NOT NULL, test_id INT PRIMARY KEY, group_id INT NOT NULL, schedule DATE NOT NULL, test_time TIME NOT NULL);
CREATE TABLE test_result (test_id INT NOT NULL, username VARCHAR(100) NOT NULL,score INT NOT NULL,ID INT PRIMARY KEY AUTO_INCREMENT);
create table groups (facultyID int NOT NULL, CourseCode varchar(8) NOT NULL, CourseSlot varchar(20) NOT NULL, groupID int PRIMARY KEY AUTO_INCREMENT);
CREATE TABLE student_group (username VARCHAR(100) NOT NULL,groupID int NOT NULL, id INT PRIMARY KEY AUTO_INCREMENT,CourseSlot VARCHAR(20) NOT NULL);
ALTER TABLE student_group ENGINE=MYISAM; # required because the entries in this table can easily go over 50,000
# to check status of storage engines of tables, 
# USE ASR
# SHOW TABLE STATUS\G

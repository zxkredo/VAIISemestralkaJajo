#deleting tables if they exist
drop table IF EXISTS admins;
drop table IF EXISTS runners;
drop table IF EXISTS personaldetails;
drop table IF EXISTS logins;

#creating database tables
CREATE TABLE logins
(
    id       int(11)      NOT NULL AUTO_INCREMENT,
    login    varchar(254) NOT NULL UNIQUE,
    password varchar(100) NOT NULL,
    name       varchar(35)  NOT NULL,
    surname    varchar(35)  NOT NULL,
    gender     varchar(10)  NOT NULL,
    birthDate  datetime     NOT NULL,
    street     varchar(95)  NOT NULL,
    city       varchar(35)  NOT NULL,
    postalCode varchar(20)  NOT NULL,
    PRIMARY KEY (id)
);

#Fiiling up tables with test values
insert into logins(login, password, name, surname, gender, birthDate, street, city, postalCode)
values ('admin@admin.com', 'admin', 'Jeff', 'Landshark', 'other', '2000-12-12 09:32:24', 'Luke\'s Bar', 'Gotham', '01112');


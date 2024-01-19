#deleting tables if they exist
drop table IF EXISTS rolepermissions;

#asociative entities
drop table IF EXISTS runparticipants;
drop table IF EXISTS userroles;
drop table IF EXISTS logins;

drop table IF EXISTS roles;
drop table IF EXISTS permissions;
drop table IF EXISTS runs;

#hitorical
drop table IF EXISTS admins;
drop table IF EXISTS runners;
drop table IF EXISTS personaldetails;

#creating database tables
CREATE TABLE logins
(
    id         int(11)      NOT NULL AUTO_INCREMENT,
    login      varchar(254) NOT NULL UNIQUE,
    password   varchar(100) NOT NULL,
    name       varchar(35)  NOT NULL,
    surname    varchar(35)  NOT NULL,
    gender     varchar(10)  NOT NULL,
    birthDate  datetime     NOT NULL,
    street     varchar(95)  NOT NULL,
    city       varchar(35)  NOT NULL,
    postalCode varchar(20)  NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE roles
(
    id          int(11)     NOT NULL AUTO_INCREMENT,
    name        varchar(35) NOT NULL UNIQUE,
    description varchar(300),
    PRIMARY KEY (id)
);

CREATE TABLE userroles
(
    id       int(11) NOT NULL AUTO_INCREMENT,
    login_id int(11) NOT NULL,
    role_id  int(11) NOT NULL,
    PRIMARY KEY (id),
    foreign key (login_id)
        references logins (id),
    foreign key (role_id)
        references roles (id)
);

CREATE TABLE permissions
(
    id          int(11)     NOT NULL AUTO_INCREMENT,
    name        varchar(35) NOT NULL UNIQUE,
    description varchar(300),
    PRIMARY KEY (id)
);

CREATE TABLE rolepermissions
(
    id            int(11) NOT NULL AUTO_INCREMENT,
    role_id       int(11) NOT NULL,
    permission_id int(11) NOT NULL,
    PRIMARY KEY (id),
    foreign key (role_id)
        references roles (id),
    foreign key (permission_id)
        references permissions (id)
);

CREATE TABLE runs
(
    id             int(11)       NOT NULL AUTO_INCREMENT,
    organiser_id   int(11)       NOT NULL,
    name           varchar(100)  NOT NULL,
    location       varchar(300)  NOT NULL,
    description    varchar(1000) NOT NULL,
    capacity       int(11)       NOT NULL,
    price_in_cents int(11)       NOT NULL,
    picture_name   varchar(300)  NOT NULL,
    PRIMARY KEY (id),
    foreign key (organiser_id)
        references logins (id)
);

CREATE TABLE runparticipants
(
    id       int(11) NOT NULL AUTO_INCREMENT,
    run_id   int(11) NOT NULL,
    login_id int(11) NOT NULL,
    PRIMARY KEY (id),
    foreign key (run_id)
        references runs (id),
    foreign key (login_id)
        references logins (id)
);

#creating roles and their permissions
insert into permissions(name, description)
values ('deleteAccount', 'The ability to delete the users account'),
       ('joinRuns', 'The ability to join created runs'),
       ('createRuns', 'The ability to create runs'),
       ('deleteRuns', 'The ability to delete runs'),
       ('viewDetailedInformationAboutRuns', 'The ability to view more detailed information about runs');

insert into roles (name, description)
values('administrator', 'Responsible for administrating the website'),
      ('runner', 'Participates in runs'),
      ('organiser', 'Organises runs'),
      ('helper', 'Helps organising runs');

#administrator can create, delete, view detailed info about runs and cannot delete their account or join runs
#runner can join runs (which also implies leaving runs) and delete their account
#organiser can create runs and view more detailed info about them, but cannot delete them, can delete account
#helpers can view more detailed info about runs and cannot delete account (it could have been created by an admins as a "guest" account)
insert into rolepermissions(role_id, permission_id)
values (1,3),
       (1,4),
       (1,5),
       (2,1),
       (2,2),
       (3,1),
       (3,3),
       (3,5),
       (4,5);

#Filling up tables with test values, admin test password is jeff
insert into logins(login, password, name, surname, gender, birthDate, street, city, postalCode)
values ('admin@admin.com', '$2y$10$h1.H9qYm92hDGy6./SWzOOGSZO2M1taKn6Wm1YTrLmBJ8/uNwkV.m', 'Jeff', 'Landshark', 'other',
        '2000-12-12 09:32:24', 'Luke\'s Bar', 'Gotham', '01112');

#Admin gets the admin role
insert into userroles(login_id, role_id)
values (1,1);
create TABLE resources (
                           id_resources serial,
                           resource_name varchar not null,
                           "date" date not null,
                           constraint PK_id_resources primary key (id_resources)
);

create table user_account (
                              id_user_account serial,
                              email varchar not null,
                              name varchar not null,
                              surname varchar not null,
                              phone varchar,
                              birth_date date,
                              id_profile_photo int,
                              can_add_competitions boolean default false,
                              constraint PK_id_user_account primary key (id_user_account),
                              constraint FK_id_profile_photo FOREIGN KEY (id_profile_photo)
                                  REFERENCES resources(id_resources) on delete cascade on update cascade
);

create table resources_on_profile (
                                      id_resources_on_profile serial,
                                      id_profile int not null,
                                      id_resource int not NULL,
                                      constraint PK_id_resources_on_profile PRIMARY KEY (id_resources_on_profile),
                                      CONSTRAINT FK_resources_on_profile_id_profile FOREIGN KEY (id_profile)
                                          REFERENCES user_account(id_user_account) on delete cascade on update cascade,
                                      CONSTRAINT FK_resources_on_profile_id_resource FOREIGN KEY (id_resource)
                                          REFERENCES resources(id_resources)  on delete cascade on update cascade
);

create table credentials(
                            id_credentials serial,
                            id_user int not null,
                            hash varchar(2048) not null,
                            "date" date not null,
                            CONSTRAINT PK_id_credentials PRIMARY KEY (id_credentials),
                            constraint FK_credentials_id_user FOREIGN KEY (id_user)
                                REFERENCES user_account(id_user_account)  on delete cascade on update cascade
);

create table revocations(
                            id_revocations serial,
                            id_credential int not null,
                            "date" date not null,
                            reasoning text,
                            constraint PK_id_revocations PRIMARY KEY (id_revocations),
                            constraint FK_revocations_id_credential FOREIGN KEY (id_credential)
                                REFERENCES credentials(id_credentials)  on delete cascade on update cascade
);

create table fisheries(
                          id_fisheries serial,
                          name varchar not null,
                          address varchar,
                          town varchar not null,
                          postal varchar,
                          latitude varchar not null,
                          longitude varchar not null,
                          CONSTRAINT PK_id_fisheries PRIMARY KEY (id_fisheries)
);

create table competitions(
                             id_competitions serial,
                             name varchar(255) not null,
                             "date" date not null,
                             gathering_time time not null,
                             start_time time not null,
                             end_time time not null,
                             code varchar not null,
                             id_place int not null,
                             sites int not null,
                             remaining_sites int not null,
                             creator int not null,
                             CONSTRAINT PK_id_competitions PRIMARY KEY (id_competitions),
                             constraint UQ_code UNIQUE (code),
                             CONSTRAINT FK_competitions_id_place FOREIGN KEY (id_place)
                                 REFERENCES fisheries(id_fisheries)  on delete cascade on update cascade,
                             CONSTRAINT FK_creator FOREIGN KEY (creator)
                                 REFERENCES user_account(id_user_account) on delete cascade on update cascade
);

CREATE TABLE announcements (
                               id_announcements serial,
                               id_competition int not null,
                               id_photo int,
                               title varchar not null,
                               content text not null,
                               "date" timestamp not null,
                               id_attachment int,
                               constraint PK_id_announcements PRIMARY KEY (id_announcements),
                               CONSTRAINT FK_announcements_id_competition FOREIGN KEY (id_competition)
                                   REFERENCES competitions(id_competitions) on delete cascade on update cascade,
                               constraint FK_announcements_id_photo FOREIGN KEY (id_photo)
                                   REFERENCES resources(id_resources) on delete cascade on update cascade,
                               constraint FK_announcements_id_attachment FOREIGN KEY (id_attachment)
                                   REFERENCES resources(id_resources) on delete cascade on update cascade
);

create table attendance (
                            id_attendance serial,
                            id_user int not null,
                            id_competition int not null,
                            position varchar not null,
                            judge bool not null default false,
                            constraint PK_id_attendance PRIMARY KEY (id_attendance),
                            CONSTRAINT FK_attendance_id_competition FOREIGN KEY (id_competition)
                                REFERENCES competitions(id_competitions) on delete cascade on update cascade,
                            constraint FK_attendance_id_user FOREIGN KEY (id_user)
                                REFERENCES user_account(id_user_account) on delete cascade on update cascade
);

create table score (
                       id_score serial,
                       id_photo int not null,
                       id_attendance int not null,
                       score int,
                       argumentation text,
                       constraint PK_id_score PRIMARY KEY (id_score),
                       CONSTRAINT FK_score_id_photo FOREIGN KEY (id_photo)
                           REFERENCES resources(id_resources) on delete cascade on update cascade,
                       CONSTRAINT FK_score_id_attendance FOREIGN KEY (id_attendance)
                           REFERENCES attendance(id_attendance) on delete cascade on update cascade
);

CREATE VIEW full_competition_info AS
SELECT  c.name as "competition_name", c.date, c.gathering_time, c.start_time, c.end_time,
        c.code, c.sites, c.remaining_sites, f.name as "fishery_name", f.address, f.town, f.postal,
        ua.name as "creator_name", ua.surname, ua.email, ua.phone
FROM competitions c
         INNER JOIN fisheries f on c.id_place = f.id_fisheries
         INNER JOIN user_account ua on c.creator = ua.id_user_account;

CREATE VIEW all_scores AS
SELECT ua.name, ua.surname, sum(s.score) as "score"
FROM attendance a
         INNER JOIN score s ON s.id_attendance = a.id_attendance
         INNER JOIN user_account ua ON a.id_user = ua.id_user_account
         INNER JOIN competitions c on a.id_competition = c.id_competitions
WHERE score is not null
GROUP BY (ua.email, ua.name, ua.surname, s.score)
ORDER BY s.score DESC;

INSERT INTO fisheries(name, address, town, postal, latitude, longitude) values
    ('Pogoria IV', 'Słoneczna 12', 'Dąbrowa Górnicza', '41-300', '50.365061539826286', '19.2066300269243');

INSERT INTO fisheries(name, address, town, postal, latitude, longitude) values
    ('Dziećkowice', 'Wesoła 13', 'Imielin', '51-323', '50.12778284497398', '19.219978966727012');

INSERT INTO fisheries(name, address, town, postal, latitude, longitude) values
    ('Kozłowa Góra', 'Prosta 6', 'Kozłowa Góra', '44-113', '50.416328694421196', '18.964251345914505');

INSERT INTO user_account(email, name, surname, can_add_competitions) values
    ('mail@mail.com', 'Admin', 'Admin', true);

-- password: Admin123 - can add competitions

INSERT INTO credentials(id_user, hash, date) values
    (1, '$2y$10$0Gv3NbbP2a5itXLlP8Ggh.z1pGOge0wADJjMJFzjI8tJ/Cg0yxSXS', '2022-01-26');

INSERT INTO user_account(email, name, surname) values
    ('gmail@gmail.com', 'Politechnika', 'Krakowska');

-- password: Politechnika123 - judge, can grade photos

INSERT INTO credentials(id_user, hash, date) values
    (1, '$2y$10$LHTsAJ9aJ/owEsBW1GvIHOztJd9S0MhGKxbBAI83iUcmPtEGzTp0y', '2022-01-26');

INSERT INTO competitions(name, date, gathering_time, start_time, end_time, code, id_place, sites, remaining_sites, creator)
    values ('Grand Prix Dąbrowy Górniczej', now(), '04:00:00', '05:00:00', '23:00:00', 'tt1DSK', 1, 70, 69, 1);

INSERT INTO attendance(id_user, id_competition, position, judge) values (1, 1, 20, false);

INSERT INTO attendance(id_user, id_competition, position, judge) values (2, 1, 30, true);

INSERT INTO announcements(id_competition, title, content, date) values (1, 'Ogłoszenie',
                                                'Zawody zostają przesunięte....', '2022-02-03 14:26:00.000000');

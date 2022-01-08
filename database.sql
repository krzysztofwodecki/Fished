create TABLE resources (
                           id_resources serial,
                           resource_path path not null,
                           constraint PK_id_resources primary key (id_resources)
);

create table user_account (
                              id_user_account serial,
                              email varchar(255) not null,
                              name varchar(100) not null,
                              surname varchar(100) not null,
                              id_profile_photo int,
                              judge boolean,
                              constraint PK_id_user_account primary key (id_user_account),
                              constraint FK_id_profile_photo FOREIGN KEY (id_profile_photo) REFERENCES resources(id_resources)
);

create table resources_on_profile (
                                      id_resources_on_profile serial,
                                      id_profile int not null,
                                      id_resource int not NULL,
                                      constraint PK_id_resources_on_profile PRIMARY KEY (id_resources_on_profile),
                                      CONSTRAINT FK_resources_on_profile_id_profile FOREIGN KEY (id_profile) REFERENCES user_account(id_user_account),
                                      CONSTRAINT FK_resources_on_profile_id_resource FOREIGN KEY (id_resource) REFERENCES resources(id_resources)
);

create table credentials(
                            id_credentials serial,
                            id_user int not null,
                            hash varchar(255) not null,
                            salt varchar(2048) not null,
                            date date not null,
                            CONSTRAINT PK_id_credentials PRIMARY KEY (id_credentials),
                            constraint FK_credentials_id_user FOREIGN KEY (id_user) REFERENCES user_account(id_user_account)
);

create table revocations(
                            id_revocations serial,
                            id_credential int not null,
                            date date not null,
                            constraint PK_id_revocations PRIMARY KEY (id_revocations),
                            constraint FK_revocations_id_credential FOREIGN KEY (id_credential) REFERENCES credentials(id_credentials)
);

create table fisheries(
                          id_fisheries serial,
                          name varchar(255) not null,
                          address varchar(255),
                          town varchar(50) not null,
                          postal varchar(10) not null,
                          coordinates varchar(255),
                          CONSTRAINT PK_id_fisheries PRIMARY KEY (id_fisheries)
);

create table competitions(
                             id_competitions serial,
                             name varchar(255) not null,
                             date date not null,
                             code varchar(10) not null,
                             id_place int not null,
                             on_boat boolean not null,
                             CONSTRAINT PK_id_competitions PRIMARY KEY (id_competitions),
                             constraint UQ_code UNIQUE (code),
                             CONSTRAINT FK_competitions_id_place FOREIGN KEY (id_place) REFERENCES fisheries(id_fisheries)
);

CREATE TABLE announcements (
                               id_announcements serial,
                               id_competition int not null,
                               id_photo int,
                               title varchar (255) not null,
                               content text not null,
                               date date not null,
                               id_attachment int,
                               constraint PK_id_announcements PRIMARY KEY (id_announcements),
                               CONSTRAINT FK_announcements_id_competition FOREIGN KEY (id_competition) REFERENCES competitions(id_competitions),
                               constraint FK_announcements_id_photo FOREIGN KEY (id_photo) REFERENCES resources(id_resources),
                               constraint FK_announcements_id_attachment FOREIGN KEY (id_attachment) REFERENCES resources(id_resources)
);

create table attendance (
                            id_attendance serial,
                            id_user int not null,
                            id_competition int not null,
                            position varchar(10),
                            sector varchar(10),
                            boat_number varchar(10),
                            constraint PK_id_attendance PRIMARY KEY (id_attendance),
                            CONSTRAINT FK_attendance_id_competition FOREIGN KEY (id_competition) REFERENCES competitions(id_competitions),
                            constraint FK_attendance_id_user FOREIGN KEY (id_user) REFERENCES user_account(id_user_account)
);

create table score (
                       id_score serial,
                       id_photo int not null,
                       id_attendance int not null,
                       score int,
                       argumentation text,
                       constraint PK_id_score PRIMARY KEY (id_score),
                       CONSTRAINT FK_score_id_photo FOREIGN KEY (id_photo) REFERENCES resources(id_resources),
                       CONSTRAINT FK_score_id_attendance FOREIGN KEY (id_attendance) REFERENCES attendance(id_attendance)
);
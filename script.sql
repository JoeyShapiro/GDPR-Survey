create table survey
(
    id            int auto_increment
        primary key,
    RID           bigint                                                                        not null,
    version       int                                                                           not null,
    page_accessed varchar(32)                                                                   not null,
    time_accessed datetime                                                                      not null,
    action        enum ('Start', 'Accept Cookie', 'Deny Cookie', 'View Policy', 'View Vaccine') not null,
    constraint id
        unique (id)
);



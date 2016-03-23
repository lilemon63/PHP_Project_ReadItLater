drop table if exists rit_link;

create table rit_link (
lnk_id integer not null primary key auto_increment,
lnk_url varchar(256) not null,
lnk_status integer not null
);

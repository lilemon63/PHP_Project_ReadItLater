drop table if exists rit_link;
drop table if exists rit_categorie;


create table rit_categorie (
    cat_id integer not null primary key auto_increment,
    cat_name varchar(128) not null
);


create table rit_link (
	lnk_id integer not null primary key auto_increment,
	lnk_url varchar(256) not null,
	lnk_status integer not null,
	lnk_content varchar(4096),
	cat_id integer,
	
    constraint fk_cat_lnk foreign key(cat_id) references rit_categorie(cat_id)
);

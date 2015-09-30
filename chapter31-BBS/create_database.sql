create database discussion;
use discussion;

create table header (
    parent int not null,
    poster char(20) not null,
    title char(20) not null,
    children int default 0 not null,
    area int default 1 not null,
    posted datetime not null,
    postid int unsigned not null auto_increment primary key
) engine=InnoDB;

create table body (
    postid int unsigned not null primary key,
    message text
) engine=InnoDB;

grant select, insert, update, delete
on discussion.*
to discussion@localhost identified by 'password';

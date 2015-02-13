-- Parse::SQL::Dia          version 0.26                              
-- Documentation            http://search.cpan.org/dist/Parse-Dia-SQL/
-- Environment              Perl 5.014002, /usr/bin/perl              
-- Architecture             i486-linux-gnu-thread-multi-64int         
-- Target Database          mysql-innodb                              
-- Input file               schemat.dia                               
-- Generated at             Fri Feb 13 18:38:12 2015                  
-- Typemap for mysql-innodb not found in input file                   

-- get_constraints_drop 
alter table Watchers drop foreign key watchers_fk_Owner_id ;
alter table Friends drop foreign key friends_fk_Owner_id ;
alter table Friends drop foreign key friends_fk_Friend_id ;
alter table Watchers drop foreign key watchers_fk_Watcher_id ;
alter table Art_Comments drop foreign key art_Comments_fk_Art_id ;
alter table Art_Comments drop foreign key art_Comments_fk_Owner_id ;
alter table Journal_Comments drop foreign key journal_Comments_fk_Journal_id ;
alter table Journal_Comments drop foreign key journal_Comments_fk_Owner_id ;
alter table Arts drop foreign key arts_fk_Owner_id ;
alter table Favourites drop foreign key favourites_fk_Art_id ;
alter table Favourites drop foreign key favourites_fk_Owner_id ;
alter table Journals drop foreign key journals_fk_Owner_id ;

-- get_permissions_drop 

-- get_view_drop

-- get_schema_drop
drop table if exists Watchers;
drop table if exists Friends;
drop table if exists Users;
drop table if exists Journals;
drop table if exists Arts;
drop table if exists Art_Comments;
drop table if exists Favourites;
drop table if exists Journal_Comments;

-- get_smallpackage_pre_sql 

-- get_schema_create
create table Watchers (
   id         int not null,
   owner_id   int         ,
   watcher_id int         ,
   constraint pk_Watchers primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Friends (
   id        int not null,
   owner_id  int         ,
   friend_id int         ,
   constraint pk_Friends primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Users (
   id       int          not null,
   nick     varchar(255)         ,
   password varchar(255)         ,
   email    varchar(255)         ,
   country  varchar(255)         ,
   status   varchar(255)         ,
   avatar   varchar(255)         ,
   constraint pk_Users primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Journals (
   id       int     not null,
   title    varchar         ,
   content  varchar         ,
   owner_id int             ,
   constraint pk_Journals primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Arts (
   id          int          not null,
   title       varchar(255)         ,
   description text                 ,
   owner_id    int                  ,
   visits      int                  ,
   constraint pk_Arts primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Art_Comments (
   id       int  not null,
   art_id   int          ,
   text     text         ,
   owner_id int          ,
   constraint pk_Art_Comments primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Favourites (
   id       int not null,
   art_id   int         ,
   owner_id int         ,
   constraint pk_Favourites primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;
create table Journal_Comments (
   id         int  not null,
   journal_id int          ,
   text       text         ,
   owner_id   int          ,
   constraint pk_Journal_Comments primary key (id)
)   ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- get_view_create

-- get_permissions_create

-- get_inserts

-- get_smallpackage_post_sql

-- get_associations_create
alter table Watchers add constraint watchers_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Friends add constraint friends_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Friends add constraint friends_fk_Friend_id 
    foreign key (friend_id)
    references Users (id) ;
alter table Watchers add constraint watchers_fk_Watcher_id 
    foreign key (watcher_id)
    references Users (id) ;
alter table Art_Comments add constraint art_Comments_fk_Art_id 
    foreign key (art_id)
    references Arts (id) ;
alter table Art_Comments add constraint art_Comments_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Journal_Comments add constraint journal_Comments_fk_Journal_id 
    foreign key (journal_id)
    references Journals (id) ;
alter table Journal_Comments add constraint journal_Comments_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Arts add constraint arts_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Favourites add constraint favourites_fk_Art_id 
    foreign key (art_id)
    references Arts (id) ;
alter table Favourites add constraint favourites_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;
alter table Journals add constraint journals_fk_Owner_id 
    foreign key (owner_id)
    references Users (id) ;

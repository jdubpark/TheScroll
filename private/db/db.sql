
create table if not exists `TheScroll`.`Users`(
  `id` int(5) unsigned not null auto_increment,
  `name_first` varchar(30) not null,
  `name_middle` varchar(30) null,
  `name_last` varchar(30) not null,
  `email` varchar(30) not null,
  `role` int(3) unsigned not null,
  `time_created` datetime not null default current_timestamp,
  `time_login_last` datetime,
  primary key (`id`),
  unique key (`email`)
);

create table if not exists `TheScroll`.`Roles`(
  `id` int(3) unsigned not null auto_increment,
  `name` varchar(30) not null,
  -- (nonself 1 => self 1)
  -- articles
  `article_access` boolean not null default 1, -- new, edit, see own
  `article_access_nonself` boolean not null default 0, -- edit, see all
  `article_delete` boolean not null default 0, -- delete own
  `article_delete_nonself` boolean not null default 0, -- delete all
  `article_status` boolean not null default 0, -- change to public/private
  -- stats
  `stat_access` boolean not null default 1, -- view own
  `stat_access_nonself` boolean not null default 0, -- view all
  -- roles
  `role_access` boolean not null default 0, -- add, update, remove roles
  `role_status` boolean not null default 0, -- change roles of users
  -- settings
  `setting_access` boolean not null default 1, -- access own
  `setting_access_nonself` boolean not null default 0, -- manage all
  -- metadata
  `time_updated` datetime not null default current_timestamp on update current_timestamp,
  `assigned` int(4) unsigned not null default 0,
  primary key (`id`)
);

create table if not exists `TheScroll`.`ArticleNormal`(
  `id` int(5) unsigned not null auto_increment,
  `author` varchar(50)
  `time_created` datetime not null default current_timestamp,
  `time_created_display` datetime not null default current_timestamp -- displayed (on the article)
  `time_updated` datetime null,
  `show_time_updated` boolean not null default 0,
  primary key (`id`)
);

create table if not exists `TheScroll`.`ContentNormal`(
  `id` int(5) unsigned not null auto_increment,
  `article_id` int(5) unsigned not null auto_increment,
  primary key (`id`),
  foreign key `ArticleId` (`article_id`)
    on delete cascade
);

create table if not exists `TheScroll`.`Updates`(

);

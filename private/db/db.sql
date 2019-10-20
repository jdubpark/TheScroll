
create database if not exists `TheScroll`
  character set = 'utf8mb4'
  collate = 'utf8mb4_unicode_ci';

-- The number of allowed characters just depends on your character set.
-- UTF8 may use up to 3 bytes per character (255), utf8mb4 up to 4 bytes (191), and latin1 only 1 byte.
-- Thus for utf8mb4 your key length is limited to 191 characters, since 4*191 = 764 < 767

create table if not exists `TheScroll`.`Users`(
  `id` int(5) unsigned not null auto_increment,
  `name_first` varchar(30) not null,
  `name_middle` varchar(30) null,
  `name_last` varchar(30) not null,
  `name_display` varchar(50) not null,
  `email` varchar(30) not null,
  `role` int(3) unsigned not null,
  `time_created` datetime not null default current_timestamp,
  `time_login_last` datetime,
  primary key (`id`),
  unique key (`email`)
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`Roles`(
  `id` int(3) unsigned not null auto_increment,
  `name` varchar(30) not null,
  -- (nonself 1 => self 1)
  `is_super` boolean not null default 0, -- super
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
  -- human resource
  `hr_access` boolean not null default 0, -- view hr
  `hr_super` boolean not null default 0, -- all other power of hr
  -- settings
  `setting_access` boolean not null default 1, -- access own
  `setting_access_nonself` boolean not null default 0, -- manage all
  -- metadata
  `time_updated` datetime not null default current_timestamp on update current_timestamp,
  `assigned` int(4) unsigned not null default 0,
  primary key (`id`)
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`Sections`(
  `id` int(3) unsigned not null auto_increment,
  `name` varchar(50) not null,
  primary key (`id`)
) ENGINE = InnoDB;

--
-- Metadata table (T1 = type 1 --> original, normal stuff)
-- NOTE: allow author, author_display, and category
--       to change when the same values in parent tables are changed
create table if not exists `TheScroll`.`ArticleT1`(
  `id` int(5) unsigned not null auto_increment,
  `author` varchar(50) not null,
  `author_display` varchar(191) not null,
  `section` varchar(50) not null,
  `time_created` datetime not null default current_timestamp,
  `time_created_display` datetime not null default current_timestamp, -- displayed (on the article)
  `time_updated` datetime null,
  `show_time_updated` boolean not null default 0,
  primary key (`id`)
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`ImageCoverT1`(
  `id` int(5) unsigned not null auto_increment,
  `article_id` int(5) unsigned not null,
  `image_link` text not null,
  primary key (`id`),
  foreign key (`article_id`)
      references `ArticleT1`(`id`)
      on delete cascade
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`SummaryT1`(
  `id` int(5) unsigned not null auto_increment,
  `article_id` int(5) unsigned not null,
  `summary` text not null,
  primary key (`id`),
  -- index articlet1_index (`article_id`),
  foreign key (`article_id`)
      references `ArticleT1`(`id`)
      on delete cascade
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`ContentT1`(
  `id` int(5) unsigned not null auto_increment,
  `article_id` int(5) unsigned not null,
  `content` text not null,
  primary key (`id`),
  -- index articlet1_index (`article_id`),
  foreign key (`article_id`)
      references `ArticleT1`(`id`)
      on delete cascade
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`CommentT1`(
  `id` int(5) unsigned not null auto_increment,
  `article_id` int(5) unsigned not null,
  `name` varchar(50) not null,
  `email` varchar(50) not null,
  `comment` text not null,
  `public` boolean not null default 1,
  `banned` boolean not null default 0,
  `time_created` datetime not null default current_timestamp,
  primary key (`id`),
  foreign key (`article_id`)
      references `ArticleT1`(`id`)
      on delete cascade
) ENGINE = InnoDB;

create table if not exists `TheScroll`.`TagsT1`(

) ENGINE = InnoDB;

create table if not exists `TheScroll`.`Updates`(

) ENGINE = InnoDB;

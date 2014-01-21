# Pi Engine schema
# http://pialog.org
# Author: Taiwen Jiang <taiwenjiang@tsinghua.org.cn>
# --------------------------------------------------------


# Object root
CREATE TABLE `{root}` (
  `id`              int(10)         unsigned    NOT NULL    auto_increment,
  `module`          varchar(64)     NOT NULL,
  `type`            varchar(64)     NOT NULL    default '',
  `item`            int(10)         unsigned    NOT NULL,

  PRIMARY KEY  (`id`),
  UNIQUE KEY  `module_item` (`module`, `type`, `item`)
);

# User actions
CREATE TABLE `{action}` (
  `id`              int(10)         unsigned    NOT NULL    auto_increment,
  `action`          varchar(64)     NOT NULL,
  `uid`             int(10)         unsigned    NOT NULL default '0',
  `root`            int(10)         unsigned    NOT NULL,
  `time`            int(10)         unsigned    NOT NULL default '0',
  `value`           text,
  `module`          varchar(64)     NOT NULL,

  PRIMARY KEY  (`id`),
  KEY  `action` (`action`),
  KEY  `uid` (`uid`),
  KEY  `root` (`root`)
);

# Action stats
CREATE TABLE `{stats}` (
  `id`              int(10)         unsigned    NOT NULL    auto_increment,
  `action`          varchar(64)     NOT NULL,
  `count`           int(10)         unsigned    NOT NULL default '0',
  `value`           int(10)         unsigned    NOT NULL default '0',
  `module`          varchar(64)     NOT NULL,

  PRIMARY KEY  (`id`),
  KEY  `action` (`action`),
  KEY  `root` (`root`)
);

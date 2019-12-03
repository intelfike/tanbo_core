CREATE TABLE user (
  id        INT  NOT NULL AUTO_INCREMENT,
  name      VARCHAR(20),
  passwd    VARCHAR(20),
  nickname  VARCHAR(20),
  update_dt DATETIME,
  create_dt DATETIME,
  primary key(id)
) ENGINE=MyISAM default character set utf8;

CREATE TABLE waku (
  id        INT  NOT NULL AUTO_INCREMENT,
  user_id   INT,
  title     TEXT,
  update_dt DATETIME,
  create_dt DATETIME,
  primary key(id)
) ENGINE=MyISAM default character set utf8;

CREATE TABLE hako (
  id        INT     NOT NULL AUTO_INCREMENT,
  user_id   INT,
  waku_id   INT     NOT NULL,
  parent_id INT     NOT NULL,
  depth     TINYINT NOT NULL,
  number    TINYINT NOT NULL,
  text      TEXT,
  update_dt DATETIME,
  create_dt DATETIME,
  primary key(id)
) ENGINE=MyISAM default character set utf8;

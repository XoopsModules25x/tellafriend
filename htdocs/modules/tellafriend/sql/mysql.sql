CREATE TABLE tellafriend_log (
  lid int unsigned NOT NULL auto_increment,
  uid mediumint(8) unsigned NOT NULL default 0,
  ip varchar(255) NOT NULL default '0.0.0.0',
  mail_fromname varchar(255) NOT NULL default '',
  mail_fromemail varchar(255) NOT NULL default '',
  mail_to varchar(255) NOT NULL default '',
  mail_subject varchar(255) NOT NULL default '',
  mail_body text NOT NULL,
  agent varchar(255) NOT NULL default '',
  timestamp TIMESTAMP ,
  PRIMARY KEY (lid)
) ENGINE=MyISAM;

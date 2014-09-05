<?php
/**
 * Created by PhpStorm.
 * User: Quoc Viet
 * Date: 02/09/2014
 * Time: 21:33
 */
$installer = $this;

$installer->startSetup();

$installer->run("

DROP TABLE IF EXISTS {$this->getTable('album/album')};
DROP TABLE IF EXISTS {$this->getTable('album/images')};
CREATE TABLE `{$installer->getTable('album/album')}` (
  `album_id` int(11) unsigned NOT NULL auto_increment,
  `albumname` varchar(255) NOT NULL default '',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE `{$installer->getTable('album/images')}` (
  `images_id` int(11) unsigned NOT NULL auto_increment,
  `imagesname` varchar(255) NOT NULL default '',
  `album_id` varchar(255) NOT NULL default '',
  PRIMARY KEY (`images_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");

$installer->endSetup();
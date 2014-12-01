CREATE TABLE tx_mkabtesting_rendered_content_elements (
	uid int(11) NOT NULL auto_increment,
	pid int(11) NOT NULL default '0',
	tstamp int(11) DEFAULT '0' NOT NULL,
	crdate int(11) DEFAULT '0' NOT NULL,
	cruser_id int(11) DEFAULT '0' NOT NULL,
	hidden tinyint(4) DEFAULT '0' NOT NULL,
	deleted tinyint(4) DEFAULT '0' NOT NULL,

	campaign_identifier varchar(255) DEFAULT '' NOT NULL,
	content_element int(11) DEFAULT '0' NOT NULL,
	render_count int(11) DEFAULT '0' NOT NULL,
	
	PRIMARY KEY (uid),
	KEY index_search_1 (campaign_identifier, content_element)
);
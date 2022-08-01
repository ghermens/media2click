CREATE TABLE tt_content
(
    tx_media2click_iframe_src VARCHAR(1024) DEFAULT '' NOT NULL,
    tx_media2click_iframe_ratio VARCHAR(16) DEFAULT '' NOT NULL,
    tx_media2click_content INT(11) DEFAULT '0' NOT NULL,
    tx_media2click_parentid INT(11) DEFAULT '0' NOT NULL,
		tx_media2click_host INT(11) DEFAULT '0' NOT NULL
);

CREATE TABLE tx_media2click_domain_model_host
(
    title VARCHAR(128) DEFAULT '' NOT NULL,
    host VARCHAR(128) DEFAULT '' NOT NULL,
    privacy_statement_link VARCHAR(1024) DEFAULT '' NOT NULL,
    placeholder text DEFAULT '' NOT NULL,
    allow_permanent int(3) DEFAULT '0' NOT NULL,
    logo int(3) DEFAULT '0' NOT NULL
);

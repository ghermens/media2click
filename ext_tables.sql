CREATE TABLE tt_content
(
    tx_media2click_iframe_src VARCHAR(1024) DEFAULT '' NOT NULL,
    tx_media2click_iframe_ratio VARCHAR(16) DEFAULT '' NOT NULL
);

CREATE TABLE tx_media2click_domain_model_host
(
    title VARCHAR(128) DEFAULT '' NOT NULL,
    host VARCHAR(128) DEFAULT '' NOT NULL,
    privacy_statement_link VARCHAR(1024) DEFAULT '' NOT NULL,
    placeholder tinytext DEFAULT '' NOT NULL
);

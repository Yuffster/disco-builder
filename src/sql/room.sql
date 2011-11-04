CREATE TABLE room (

	id INT(11),

	area_id INT(11) NOT NULL,

	x INT(11) NOT NULL,
	y INT(11) NOT NULL,
	z INT(11) DEFAULT 0,

	short VARCHAR(150),
	`long` TEXT,
	`type` INT(11),

	exit_n INT(11),
	exit_s INT(11),
	exit_e INT(11),
	exit_w INT(11),

	exit_ne INT(11),
	exit_se INT(11),
	exit_nw INT(11),
	exit_sw INT(11),

	PRIMARY KEY(id)

);

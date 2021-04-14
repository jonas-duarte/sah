CREATE TABLE users
(
	id SERIAL PRIMARY KEY,
	email VARCHAR(256),
	password VARCHAR(50)
);

CREATE TABLE tokens
(
	token VARCHAR PRIMARY KEY,
	user_id INTEGER REFERENCES users (id)
);

CREATE TABLE history
(
	id SERIAL PRIMARY KEY,
	event_date DATE,
	event_start TIME,
	event_end TIME,
	justificatory VARCHAR(256),
	user_id INTEGER REFERENCES users (id)
);


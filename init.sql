USE tabling;

CREATE TABLE providers (
id SERIAL PRIMARY KEY,
name VARCHAR(16),
address VARCHAR(32)
);

CREATE TABLE teams (
id SERIAL PRIMARY KEY,
name VARCHAR(16)
);

CREATE TABLE leaders (
id SERIAL PRIMARY KEY,
first VARCHAR(16),
last VARCHAR(16),
email VARCHAR(32),
cell CHAR(10),
team INTEGER REFERENCES teams(id),
provider INTEGER REFERENCES providers (id)
);

CREATE TABLE days (
id SERIAL PRIMARY KEY,
date DATE,
active BOOLEAN
);

CREATE TABLE shifts (
id SERIAL PRIMARY KEY,
time VARCHAR(20),
location VARCHAR(16),
day INTEGER REFERENCES days (id)
);

CREATE TABLE signups (
id SERIAL PRIMARY KEY,
leader INTEGER REFERENCES leaders (id),
shift INTEGER REFERENCES shifts (id)
);
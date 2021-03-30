CREATE DATABASE task_force_1
	DEFAULT CHARACTER SET utf8
	DEFAULT COLLATE UTF8_GENERAL_CI;

USE task_force_1;

CREATE TABLE cities (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(100) NOT NULL,
	latitude DECIMAL(11, 8) NOT NULL,
	longitude DECIMAL(11, 8) NOT NULL
);

CREATE TABLE users (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	city_id INT UNSIGNED NOT NULL,
	signing_up_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	role VARCHAR(50) NOT NULL,
	name VARCHAR(300) NOT NULL,
	email VARCHAR(300) NOT NULL,
	password VARCHAR(3000) NOT NULL,
	avatar VARCHAR(1000),
	birthday DATE,
	description VARCHAR(3000),
	phone VARCHAR(100),
	skype VARCHAR(100),
	telegram VARCHAR(100),
	favorite_count INT UNSIGNED NOT NULL,
	failure_count INT UNSIGNED NOT NULL,
	address VARCHAR(500),
	last_activity TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX city_id (city_id),
	FOREIGN KEY (city_id)
		REFERENCES cities(id)
		ON DELETE RESTRICT
);

CREATE TABLE users_accomplished_tasks_photos (
	user_id INT UNSIGNED NOT NULL,
	accomplished_task_photo VARCHAR(1000) NOT NULL,
	INDEX user_id (user_id),
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE
);

CREATE TABLE users_optional_settings (
	user_id INT UNSIGNED NOT NULL PRIMARY KEY,
	is_hidden_contacts BOOLEAN NOT NULL,
	is_hidden_account BOOLEAN NOT NULL,
	is_subscribed_messages BOOLEAN NOT NULL,
	is_subscribed_actions BOOLEAN NOT NULL,
	is_subscribed_reviews BOOLEAN NOT NULL,
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE
);

CREATE TABLE specializations (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(500) NOT NULL,
	icon VARCHAR(300) NOT NULL 
);

CREATE TABLE tasks (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	customer_id INT UNSIGNED NOT NULL,
	executant_id INT UNSIGNED,
	city_id INT UNSIGNED,
	specialization_id INT UNSIGNED,
	posting_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, 
	status VARCHAR(50) NOT NULL,
	name VARCHAR(1000) NOT NULL,
	description VARCHAR(3000) NOT NULL,
	latitude DECIMAL(11, 8),
	longitude DECIMAL(11, 8),
	payment VARCHAR(500),
	deadline_date TIMESTAMP,
	address VARCHAR(500),
	FULLTEXT INDEX name_description (name, description),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id),
	INDEX city_id (city_id),
	INDEX specialization_id (specialization_id),
	FOREIGN KEY (customer_id)
		REFERENCES users(id)
		ON DELETE RESTRICT,
	FOREIGN KEY (executant_id)
		REFERENCES users(id)
		ON DELETE RESTRICT,
	FOREIGN KEY (city_id)
		REFERENCES cities(id)
		ON DELETE RESTRICT,
	FOREIGN KEY (specialization_id)
		REFERENCES specializations(id)
		ON DELETE RESTRICT
);

CREATE TABLE task_helpful_files (
	task_id INT UNSIGNED NOT NULL, 
	helpful_file VARCHAR(1000) NOT NULL,
	INDEX task_id (task_id),
	FOREIGN KEY (task_id)
		REFERENCES tasks(id)
		ON DELETE CASCADE
);

CREATE TABLE notifications_history (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	recipient_id INT UNSIGNED NOT NULL,
	task_id INT UNSIGNED NOT NULL,
	event_type ENUM('1', '2', '3', '4', '5') NOT NULL,
	is_shown BOOLEAN NOT NULL,
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX recipient_id (recipient_id),
	INDEX task_id (task_id),
	FOREIGN KEY (recipient_id)
		REFERENCES users(id)
		ON DELETE CASCADE,
	FOREIGN KEY (task_id)
		REFERENCES tasks(id)
		ON DELETE CASCADE
);

CREATE TABLE responses (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	task_id INT UNSIGNED NOT NULL,
	payment INT UNSIGNED,
	comment VARCHAR(3000),
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX user_id (user_id),
	INDEX task_id (task_id),
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE,
	FOREIGN KEY (task_id)
		REFERENCES tasks(id)
		ON DELETE CASCADE
);

CREATE TABLE chat_messages (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	task_id INT UNSIGNED NOT NULL,
	message VARCHAR(3000) NOT NULL,
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX user_id (user_id),
	INDEX task_id (task_id),
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE,
	FOREIGN KEY (task_id)
		REFERENCES tasks(id)
		ON DELETE CASCADE
);

CREATE TABLE reviews (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	adding_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	task_id INT UNSIGNED NOT NULL,
	customer_id INT UNSIGNED NOT NULL,
	executant_id INT UNSIGNED NOT NULL,
	completion ENUM('1', '2') NOT NULL,
	comment VARCHAR(3000),
	rate INT UNSIGNED NOT NULL,
	INDEX task_id (task_id),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id),
	FOREIGN KEY (task_id)
		REFERENCES tasks(id)
		ON DELETE CASCADE,
	FOREIGN KEY (customer_id)
		REFERENCES users(id)
		ON DELETE CASCADE,
	FOREIGN KEY (executant_id)
		REFERENCES users(id)
		ON DELETE CASCADE
);

CREATE TABLE user_specialization (
	user_id INT UNSIGNED NOT NULL,
	specialization_id INT UNSIGNED NOT NULL,
	PRIMARY KEY (user_id, specialization_id),
	INDEX user_id (user_id),
	INDEX specialization_id (specialization_id),
	FOREIGN KEY (user_id)
		REFERENCES users(id)
		ON DELETE CASCADE,
	FOREIGN KEY (specialization_id)
		REFERENCES specializations(id)
		ON DELETE CASCADE
);
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
	city_id INT UNSIGNED NOT NULL REFERENCES cities(id) ON DELETE RESTRICT,
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
	INDEX city_id (city_id)
);

CREATE TABLE users_accomplished_tasks_photos (
	user_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	accomplished_task_photo VARCHAR(1000) NOT NULL,
	INDEX user_id (user_id)
);

CREATE TABLE users_optional_settings (
	user_id INT UNSIGNED NOT NULL PRIMARY KEY REFERENCES users(id) ON DELETE CASCADE,
	is_hidden_contacts BOOLEAN NOT NULL,
	is_hidden_account BOOLEAN NOT NULL,
	is_subscribed_messages BOOLEAN NOT NULL,
	is_subscribed_actions BOOLEAN NOT NULL,
	is_subscribed_reviews BOOLEAN NOT NULL
);

CREATE TABLE specializations (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(500) NOT NULL,
	icon VARCHAR(300) NOT NULL
);

CREATE TABLE tasks (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	customer_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE RESTRICT,
	executant_id INT UNSIGNED REFERENCES users(id) ON DELETE RESTRICT,
	city_id INT UNSIGNED REFERENCES cities(id) ON DELETE RESTRICT,
	specialization_id INT UNSIGNED REFERENCES specializations(id) ON DELETE RESTRICT,
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
	INDEX specialization_id (specialization_id)
);

CREATE TABLE task_helpful_files (
	task_id INT UNSIGNED NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	helpful_file VARCHAR(1000) NOT NULL,
	INDEX task_id (task_id)
);

CREATE TABLE notifications_history (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	recipient_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	task_id INT UNSIGNED NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	event_type ENUM('1', '2', '3', '4', '5') NOT NULL,
	is_shown BOOLEAN NOT NULL,
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX recipient_id (recipient_id),
	INDEX task_id (task_id)
);

CREATE TABLE responses (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	task_id INT UNSIGNED NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	payment INT UNSIGNED,
	comment VARCHAR(3000),
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);

CREATE TABLE chat_messages (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE SET NULL,
	task_id INT UNSIGNED NOT NULL REFERENCES tasks(id) ON DELETE SET NULL,
	message VARCHAR(3000) NOT NULL,
	date_time TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	INDEX user_id (user_id),
	INDEX task_id (task_id)
);

CREATE TABLE reviews (
	id INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
	adding_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	task_id INT UNSIGNED NOT NULL REFERENCES tasks(id) ON DELETE CASCADE,
	customer_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	executant_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	completion ENUM('1', '2') NOT NULL,
	comment VARCHAR(3000),
	rating INT UNSIGNED,
	INDEX task_id (task_id),
	INDEX customer_id (customer_id),
	INDEX executant_id (executant_id)
);

CREATE TABLE user_specialization (
	user_id INT UNSIGNED NOT NULL REFERENCES users(id) ON DELETE CASCADE,
	specialization_id INT UNSIGNED NOT NULL REFERENCES specializations(id) ON DELETE CASCADE,
	PRIMARY KEY (user_id, specialization_id),
	INDEX user_id (user_id),
	INDEX specialization_id (specialization_id)
);

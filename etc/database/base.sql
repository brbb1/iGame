CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255)        NOT NULL
);

CREATE TABLE IF NOT EXISTS `players_type`
(
    `id`                 INT AUTO_INCREMENT PRIMARY KEY,
    `type`               VARCHAR(15) UNIQUE NOT NULL,
    `points_coefficient` SMALLINT           NOT NULL
);

CREATE TABLE IF NOT EXISTS `players`
(
    `id`           INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `user_id`      INT                NOT NULL,
    `type_id`      INT                NOT NULL,
    `bank_account` VARCHAR(255)       NOT NULL,
    `address`      VARCHAR(511)       NOT NULL,
    FOREIGN KEY (`user_id`) REFERENCES users (`id`),
    FOREIGN KEY (`type_id`) REFERENCES players_type (`id`)
);

CREATE TABLE IF NOT EXISTS `points`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `max_count` INT NOT NUll
);

CREATE TABLE IF NOT EXISTS `money`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `budget` INT NOT NULL
);

CREATE TABLE IF NOT EXISTS `objects`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `name` VARCHAR(511) NOT NULl
);


CREATE TABLE IF NOT EXISTS `draws`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `name` VARCHAR(255) NOT NULL,
    `point_id` INT NOT NUll,
    `point_chance` SMALLINT NOT NULL,
    `money_id` INT NOT NULL,
    `money_chance` SMALLINT NOT NULL,
    `current_budget` INT NOT NULL,
    `object_id`INT NOT NULL,
    `object_chance` SMALLINT NOT NULL,
    `current_object_ctn` SMALLINT NOT NULL,
    FOREIGN KEY (`point_id`) REFERENCES points (`id`),
    FOREIGN KEY (`money_id`) REFERENCES money (`id`),
    FOREIGN KEY (`object_id`) REFERENCES objects (`id`),
    CHECK (draws.point_chance + draws.money_chance + draws.object_chance = 100)
);

CREATE TABLE IF NOT EXISTS `player_points`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id` INT NOT NULL,
    `points_id` INT NOT NUll,
    `status` VARCHAR(127) NOT NULL,
    `count` INT NOT NULL,
    FOREIGN KEY (`points_id`) REFERENCES points (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

CREATE TABLE IF NOT EXISTS `players_money`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id` INT NOT NULL,
    `money_id` INT NOT NUll,
    `points_prize_id` INT,
    `status` VARCHAR(127) NOT NULL,
    `count` INT NOT NULL,
    FOREIGN KEY (`money_id`) REFERENCES money (`id`),
    FOREIGN KEY (`points_prize_id`) REFERENCES player_points (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

CREATE TABLE IF NOT EXISTS `players_objects`
(
    `id` INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id` INT NOT NULL,
    `object_id` INT NOT NUll,
    `status` VARCHAR(127) NOT NULL,
    FOREIGN KEY (`object_id`) REFERENCES objects (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

INSERT INTO `users` (id, name, password)
VALUES (1, 'user1', 'pass1');
INSERT INTO `users` (id, name, password)
VALUES (2, 'user2', 'pass2');


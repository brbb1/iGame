CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255)        NOT NULL
);

CREATE TABLE IF NOT EXISTS `player_types`
(
    `id`                 INT AUTO_INCREMENT PRIMARY KEY,
    `name`               VARCHAR(15) UNIQUE NOT NULL,
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
    FOREIGN KEY (`type_id`) REFERENCES player_types (`id`)
);

CREATE TABLE IF NOT EXISTS `draws`
(
    `id`                 INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `name`               VARCHAR(255)       NOT NULL,
    `point_chance`       SMALLINT           NOT NULL,
    `max_points`         INT                NOT NULL,
    `money_chance`       SMALLINT           NOT NULL,
    `current_budget`     INT                NOT NULL,
    `object_chance`      SMALLINT           NOT NULL,
    `current_object_ctn` SMALLINT           NOT NULL,
    CHECK (draws.point_chance + draws.money_chance + draws.object_chance = 100)
);

CREATE TABLE IF NOT EXISTS `players_draws`
(
    `player_id` INT NOT NULL,
    `draws_id`  INT NOT NULL,
    `count`     INT NOT NULL,
    PRIMARY KEY (`player_id`, `draws_id`)
);

CREATE TABLE IF NOT EXISTS `prize_points`
(
    `id`        INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `draw_id`   INT,
    `max_count` INT                NOT NUll,
    FOREIGN KEY (`draw_id`) REFERENCES draws (`id`)
);

CREATE TABLE IF NOT EXISTS `prize_money`
(
    `id`      INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `draw_id` INT,
    `budget`  INT                NOT NULL,
    FOREIGN KEY (`draw_id`) REFERENCES draws (`id`)
);

CREATE TABLE IF NOT EXISTS `prize_objects`
(
    `id`      INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `draw_id` INT,
    `name`    VARCHAR(511)       NOT NULl,
    FOREIGN KEY (`draw_id`) REFERENCES draws (`id`)
);

CREATE TABLE IF NOT EXISTS `player_points`
(
    `id`        INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id` INT                NOT NULL,
    `points_id` INT                NOT NUll,
    `status`    VARCHAR(127)       NOT NULL,
    `count`     INT                NOT NULL,
    FOREIGN KEY (`points_id`) REFERENCES prize_points (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

CREATE TABLE IF NOT EXISTS `player_money`
(
    `id`              INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id`       INT                NOT NULL,
    `money_id`        INT                NOT NUll,
    `points_prize_id` INT,
    `status`          VARCHAR(127)       NOT NULL,
    `count`           INT                NOT NULL,
    FOREIGN KEY (`money_id`) REFERENCES prize_money (`id`),
    FOREIGN KEY (`points_prize_id`) REFERENCES player_points (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

CREATE TABLE IF NOT EXISTS `player_objects`
(
    `id`        INT AUTO_INCREMENT NOT NULL PRIMARY KEY,
    `player_id` INT                NOT NULL,
    `object_id` INT                NOT NUll,
    `status`    VARCHAR(127)       NOT NULL,
    FOREIGN KEY (`object_id`) REFERENCES prize_objects (`id`),
    FOREIGN KEY (`player_id`) REFERENCES players (`id`)
);

INSERT INTO `users` (id, name, password)
VALUES (1, 'user1', 'pass1');
INSERT INTO `users` (id, name, password)
VALUES (2, 'user2', 'pass2');
INSERT INTO `player_types`(id, name, points_coefficient)
VALUES (1, 'VIP', 1000);
INSERT INTO `players` (id, user_id, type_id, bank_account, address)
VALUES (2, 1, 1, 'visa', 'kazahstan');
INSERT INTO `draws` (id, name, point_chance, max_points, money_chance, current_budget, object_chance,
                     current_object_ctn)
VALUES (1, 'black friday', 60, 100000, 30, 100000000, 10, 10);
INSERT INTO `prize_points` (id, draw_id, max_count)
VALUES (1, 1, 100000);
INSERT INTO `prize_money` (id, draw_id, budget)
VALUES (1, 1, 100000000);
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (1, 1, 'cheep car');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (2, 1, 'cheep car');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (3, 1, 'super car');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (4, 1, 'iphone');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (5, 1, 'iphone');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (6, 1, 'iphone');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (7, 1, 'iphone');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (8, 1, 'notebook');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (9, 1, 'notebook');
INSERT INTO `prize_objects` (id, draw_id, name)
VALUES (10, 1, 'notebook');
INSERT INTO `players_draws` (player_id, draws_id, count)
VaLUES (1, 1, 100);


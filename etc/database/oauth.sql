CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) UNIQUE NOT NULL,
    `password` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tokens`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `token`    VARCHAR(511) NOT NULL,
    expired_at DATETIME     NOT NULL
);

INSERT INTO `users` (id, name, password) VALUES (1, 'user1', 'pass1');
INSERT INTO `users` (id, name, password) VALUES (2, 'user2', 'pass2');


CREATE TABLE IF NOT EXISTS `users`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `name`     VARCHAR(255) NOT NULL,
    `password` VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS `tokens`
(
    `id`       INT AUTO_INCREMENT PRIMARY KEY,
    `token`    VARCHAR(511) NOT NULL,
    expired_at DATETIME     NOT NULL
);

INSERT INTO `users` (name, password) VALUES ('user', 'pass');


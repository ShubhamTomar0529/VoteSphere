
DROP DATABASE IF EXISTS `voting`;
CREATE DATABASE `voting` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `voting`;

CREATE TABLE `admin` (
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(50)  NOT NULL,
    `email`      VARCHAR(100) NOT NULL,
    `password`   VARCHAR(255) NOT NULL,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_admin_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `admin` (`id`, `name`, `email`, `password`) VALUES
(1, 'admin', 'admin@gmail.com', 'admin');


CREATE TABLE `register` (
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `fname`      VARCHAR(50)  NOT NULL,
    `lname`      VARCHAR(50)  NOT NULL,
    `idname`     VARCHAR(50)  NOT NULL,            
    `idnum`      VARCHAR(50)  NOT NULL,             
    `idcard`     VARCHAR(300) NOT NULL,              
    `inst_id`    VARCHAR(20)  NOT NULL,              
    `dob`        DATE         NOT NULL,
    `gender`     VARCHAR(10)  NOT NULL,
    `phone`      VARCHAR(15)  NOT NULL,
    `address`    VARCHAR(200) NOT NULL,
    `verify`     VARCHAR(10)  NOT NULL DEFAULT 'no',
    `status`     VARCHAR(15)  NOT NULL DEFAULT 'not voted',
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_register_phone`   (`phone`),
    UNIQUE KEY `uq_register_idnum`   (`idnum`),
    UNIQUE KEY `uq_register_inst_id` (`inst_id`),

    
    CONSTRAINT `chk_register_gender` CHECK (`gender` IN ('male', 'female', 'other', 'Male', 'Female', 'Other')),
    CONSTRAINT `chk_register_verify` CHECK (`verify` IN ('yes', 'no')),
    CONSTRAINT `chk_register_status` CHECK (`status` IN ('not voted', 'voted'))
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE INDEX `idx_register_phone` ON `register` (`phone`);


CREATE TABLE `can_position` (
    `id`              INT          NOT NULL AUTO_INCREMENT,
    `position_name`   VARCHAR(50)  NOT NULL,
    `title`           VARCHAR(255) NOT NULL,
    `start_datetime`  DATETIME     NOT NULL,
    `end_datetime`    DATETIME     NOT NULL,
    `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_position_name` (`position_name`),

    CONSTRAINT `chk_position_dates` CHECK (`end_datetime` > `start_datetime`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


CREATE TABLE `candidate` (
    `id`          INT          NOT NULL AUTO_INCREMENT,
    `cname`       VARCHAR(50)  NOT NULL,
    `symbol`      VARCHAR(50)  NOT NULL,
    `symphoto`    VARCHAR(300) NOT NULL,              
    `position_id` INT          NOT NULL,
    `tvotes`      INT          NOT NULL DEFAULT 0,    
    `created_at`  DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_candidate_symbol` (`symbol`),

    CONSTRAINT `fk_candidate_position`
        FOREIGN KEY (`position_id`) REFERENCES `can_position` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX `idx_candidate_position` ON `candidate` (`position_id`);


CREATE TABLE `votes` (
    `id`           INT      NOT NULL AUTO_INCREMENT,
    `user_id`      INT      NOT NULL,
    `position_id`  INT      NOT NULL,
    `candidate_id` INT      NOT NULL,
    `created_at`   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`),

    
    UNIQUE KEY `uq_votes_user_position` (`user_id`, `position_id`),

    CONSTRAINT `fk_votes_user`
        FOREIGN KEY (`user_id`) REFERENCES `register` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_votes_position`
        FOREIGN KEY (`position_id`) REFERENCES `can_position` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT `fk_votes_candidate`
        FOREIGN KEY (`candidate_id`) REFERENCES `candidate` (`id`)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE INDEX `idx_votes_user`      ON `votes` (`user_id`);
CREATE INDEX `idx_votes_candidate` ON `votes` (`candidate_id`);
CREATE INDEX `idx_votes_position`  ON `votes` (`position_id`);


CREATE TABLE `phno_change` (
    `id`         INT          NOT NULL AUTO_INCREMENT,
    `vname`      VARCHAR(50)  NOT NULL,
    `idname`     VARCHAR(20)  NOT NULL,
    `idcard`     VARCHAR(300) NOT NULL,
    `dob`        DATE         NOT NULL,
    `old_phno`   VARCHAR(15)  NOT NULL,
    `new_phno`   VARCHAR(15)  NOT NULL,
    `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,

    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;



DELIMITER $$

CREATE TRIGGER `trg_votes_check_verified`
BEFORE INSERT ON `votes`
FOR EACH ROW
BEGIN
    DECLARE v_verify VARCHAR(10);

    SELECT `verify`
      INTO v_verify
      FROM `register`
     WHERE `id` = NEW.`user_id`;

    IF v_verify != 'yes' THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: Only verified users can vote.';
    END IF;
END$$

CREATE TRIGGER `trg_votes_after_insert`
AFTER INSERT ON `votes`
FOR EACH ROW
BEGIN
    UPDATE `candidate`
       SET `tvotes` = `tvotes` + 1
     WHERE `id` = NEW.`candidate_id`;
END$$

CREATE TRIGGER `trg_votes_after_delete`
AFTER DELETE ON `votes`
FOR EACH ROW
BEGIN
    UPDATE `candidate`
       SET `tvotes` = `tvotes` - 1
     WHERE `id` = OLD.`candidate_id`;
END$$


CREATE PROCEDURE `sp_cast_vote` (
    IN p_user_id      INT,
    IN p_position_id  INT,
    IN p_candidate_id INT
)
BEGIN
    DECLARE v_already_voted INT DEFAULT 0;

    
    SELECT COUNT(*) INTO v_already_voted
      FROM `votes`
     WHERE `user_id`     = p_user_id
       AND `position_id` = p_position_id;

    IF v_already_voted > 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'ERROR: You have already voted for this position.';
    ELSE
        INSERT INTO `votes` (`user_id`, `position_id`, `candidate_id`)
        VALUES (p_user_id, p_position_id, p_candidate_id);
    END IF;
END$$

DELIMITER ;



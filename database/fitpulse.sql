CREATE DATABASE IF NOT EXISTS `fitpulse`
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE `fitpulse`;

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

DROP TABLE IF EXISTS `reviews`;
DROP TABLE IF EXISTS `nutrition_logs`;
DROP TABLE IF EXISTS `exercises`;
DROP TABLE IF EXISTS `workouts`;
DROP TABLE IF EXISTS `users`;

SET FOREIGN_KEY_CHECKS = 1;

CREATE TABLE `users` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(255) NOT NULL,
    `password_hash` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    UNIQUE KEY `uq_users_email` (`email`)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `workouts` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `title` VARCHAR(150) NOT NULL,
    `description` TEXT NULL,
    `category` VARCHAR(80) NOT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_workouts_user_id` (`user_id`),
    CONSTRAINT `fk_workouts_user`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `exercises` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `workout_id` INT UNSIGNED NOT NULL,
    `name` VARCHAR(150) NOT NULL,
    `muscle_group` VARCHAR(80) NOT NULL,
    `default_sets` INT UNSIGNED NOT NULL,
    `default_reps` INT UNSIGNED NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_exercises_workout_id` (`workout_id`),
    CONSTRAINT `fk_exercises_workout`
        FOREIGN KEY (`workout_id`) REFERENCES `workouts` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `chk_exercises_default_sets` CHECK (`default_sets` > 0),
    CONSTRAINT `chk_exercises_default_reps` CHECK (`default_reps` > 0)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `nutrition_logs` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `meal_type` VARCHAR(50) NOT NULL,
    `calories` INT UNSIGNED NOT NULL,
    `protein_grams` DECIMAL(7,2) UNSIGNED NOT NULL,
    `date` DATE NOT NULL,
    PRIMARY KEY (`id`),
    KEY `idx_nutrition_logs_user_date` (`user_id`, `date`),
    CONSTRAINT `fk_nutrition_logs_user`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `chk_nutrition_logs_calories` CHECK (`calories` >= 0),
    CONSTRAINT `chk_nutrition_logs_protein` CHECK (`protein_grams` >= 0)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `reviews` (
    `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
    `user_id` INT UNSIGNED NOT NULL,
    `workout_id` INT UNSIGNED NOT NULL,
    `rating` TINYINT UNSIGNED NOT NULL,
    `comment` TEXT NULL,
    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_reviews_user_id` (`user_id`),
    KEY `idx_reviews_workout_id` (`workout_id`),
    CONSTRAINT `fk_reviews_user`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `fk_reviews_workout`
        FOREIGN KEY (`workout_id`) REFERENCES `workouts` (`id`)
        ON UPDATE CASCADE
        ON DELETE RESTRICT,
    CONSTRAINT `chk_reviews_rating` CHECK (`rating` BETWEEN 1 AND 5)
) ENGINE=InnoDB
  DEFAULT CHARACTER SET=utf8mb4
  COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `name`, `email`, `password_hash`, `role`, `created_at`) VALUES
    (1, 'Alex Morgan', 'alex.morgan@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'admin', '2026-01-05 09:00:00'),
    (2, 'Jordan Lee', 'jordan.lee@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'user', '2026-01-06 10:30:00'),
    (3, 'Taylor Smith', 'taylor.smith@example.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'user', '2026-01-07 14:15:00');

INSERT INTO `workouts` (`id`, `user_id`, `title`, `description`, `category`, `created_at`) VALUES
    (1, 1, 'Full Body Strength', 'A balanced strength routine for the main movement patterns.', 'Strength', '2026-01-08 08:00:00'),
    (2, 2, 'Upper Body Push', 'A focused push-day routine for chest, shoulders, and triceps.', 'Strength', '2026-01-09 17:30:00'),
    (3, 3, 'Cardio Conditioning', 'A progressive routine combining intervals and steady-state cardio.', 'Cardio', '2026-01-10 07:45:00');

INSERT INTO `exercises` (`id`, `workout_id`, `name`, `muscle_group`, `default_sets`, `default_reps`) VALUES
    (1, 1, 'Barbell Squat', 'Legs', 4, 8),
    (2, 1, 'Dumbbell Row', 'Back', 3, 10),
    (3, 1, 'Plank', 'Core', 3, 45),
    (4, 2, 'Bench Press', 'Chest', 4, 8),
    (5, 2, 'Overhead Press', 'Shoulders', 3, 10),
    (6, 3, 'Treadmill Intervals', 'Cardio', 6, 1);

INSERT INTO `nutrition_logs` (`id`, `user_id`, `meal_type`, `calories`, `protein_grams`, `date`) VALUES
    (1, 2, 'Breakfast', 520, 32.50, '2026-01-12'),
    (2, 2, 'Lunch', 680, 46.00, '2026-01-12'),
    (3, 2, 'Dinner', 740, 54.25, '2026-01-12'),
    (4, 3, 'Breakfast', 430, 28.00, '2026-01-12'),
    (5, 3, 'Snack', 260, 21.50, '2026-01-12');

INSERT INTO `reviews` (`id`, `user_id`, `workout_id`, `rating`, `comment`, `created_at`) VALUES
    (1, 2, 1, 5, 'Clear progression and a good balance of compound movements.', '2026-01-13 12:00:00'),
    (2, 3, 2, 4, 'Good upper-body routine; the volume is challenging but manageable.', '2026-01-14 16:20:00'),
    (3, 1, 3, 5, 'A practical conditioning plan with useful interval structure.', '2026-01-15 09:10:00');

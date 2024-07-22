CREATE TABLE form (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE schoolclass (id INT AUTO_INCREMENT NOT NULL, form_id INT NOT NULL, name VARCHAR(255) NOT NULL, color VARCHAR(255) NOT NULL, is_archived TINYINT(1) NOT NULL, INDEX IDX_F146B6695FF69B7D (form_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE students (id INT AUTO_INCREMENT NOT NULL, class_id INT NOT NULL, lastname VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, INDEX IDX_A4698DB2EA000B10 (class_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, schoolclass_id INT NOT NULL, date DATE NOT NULL, trimester INT NOT NULL, description VARCHAR(255) NOT NULL, scale INT NOT NULL, coefficient INT NOT NULL, INDEX IDX_D87F7E0CC67D8F5 (schoolclass_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_USERNAME (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;
ALTER TABLE schoolclass ADD CONSTRAINT FK_F146B6695FF69B7D FOREIGN KEY (form_id) REFERENCES form (id);
ALTER TABLE students ADD CONSTRAINT FK_A4698DB2EA000B10 FOREIGN KEY (class_id) REFERENCES schoolclass (id);
ALTER TABLE test ADD CONSTRAINT FK_D87F7E0CC67D8F5 FOREIGN KEY (schoolclass_id) REFERENCES schoolclass (id);

INSERT INTO `user` (`username`, `roles`, `password`) VALUES ('a_pierrepont', '[]', '$2y$13$f8wB7blFJ.hBfvbo/YKAuuiJFn2QHakIYYw2ChZmtwK240kRF9iJy');

INSERT INTO `form` (`name`) VALUES ('2ND'), ('1G'), ('1HLP'), ('1STMG'), ('BTS');

INSERT INTO `schoolclass` (`id`, `name`, `color`, `is_archived`, `form_id`) 
VALUES (1, '2D5', 'red', 0, 1),  
(2, '1G4', 'blue', 0, 2), 
(3, '1HLP1', 'green', 0, 3), 
(4, '1STMG2', 'yellow', 0, 4),
(5, 'BTS1', 'pink', 0, 5);

INSERT INTO `students` (`firstname`, `lastname`, `class_id`)
VALUES 
('John', 'Doe', 1),
('Jane', 'Smith', 2),
('Alice', 'Johnson', 3),
('Bob', 'Brown', 4),
('Carol', 'Davis', 5),
('Daniel', 'Miller', 1),
('Emma', 'Wilson', 2),
('Frank', 'Moore', 3),
('Grace', 'Taylor', 4),
('Henry', 'Anderson', 5),
('Ivy', 'Thomas', 1),
('Jack', 'Jackson', 2),
('Kara', 'White', 3),
('Liam', 'Harris', 4),
('Mia', 'Martin', 5),
('Noah', 'Thompson', 1),
('Olivia', 'Garcia', 2),
('Paul', 'Martinez', 3),
('Quinn', 'Robinson', 4),
('Ruby', 'Clark', 5);

CREATE TABLE `student_test` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `student_id` int(11) NOT NULL,
  `test_id` int(11) NOT NULL,
  `mark` int(11) NOT NULL,
  `skill1` int(11) DEFAULT NULL,
  `skill2` int(11) DEFAULT NULL,
  `skill3` int(11) DEFAULT NULL,
  `skill4` int(11) DEFAULT NULL,
  `skill5` int(11) DEFAULT NULL,
  PRIMARY KEY(`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

ALTER TABLE `student_test`
  ADD KEY `IDX_E75C05D4CB944F1A` (`student_id`),
  ADD KEY `IDX_E75C05D41E5D0459` (`test_id`);
  
ALTER TABLE `student_test`
  ADD CONSTRAINT `FK_E75C05D41E5D0459` FOREIGN KEY (`test_id`) REFERENCES `test` (`id`),
  ADD CONSTRAINT `FK_E75C05D4CB944F1A` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`);

INSERT INTO `test` (`id`, `schoolclass_id`, `date`, `trimester`, `description`, `scale`, `coefficient`) VALUES
(21, 1, '2024-01-15', 1, 'Math Test 1', 20, 1),
(23, 1, '2024-03-05', 1, 'Science Test 1', 20, 1),
(24, 1, '2024-03-25', 1, 'Science Test 2', 20, 1),
(25, 1, '2024-04-10', 1, 'History Test 1', 20, 1),
(26, 1, '2024-04-30', 1, 'History Test 2', 20, 1),
(27, 1, '2024-05-15', 1, 'Geography Test 1', 20, 1),
(28, 1, '2024-06-01', 1, 'Geography Test 2', 20, 1),
(29, 1, '2024-06-20', 1, 'Literature Test 1', 20, 1),
(30, 1, '2024-07-05', 1, 'Literature Test 2', 20, 1),
(31, 1, '2024-07-10', 2, 'Lecture', 20, 2),
(32, 2, '2024-07-09', 2, 'Lecture', 20, 1);

INSERT INTO `student_test` (`id`, `student_id`, `test_id`, `mark`, `skill1`, `skill2`, `skill3`, `skill4`, `skill5`) VALUES
(25, 1, 23, 19, 3, 3, 2, 4, 1),
(26, 1, 24, 13, 2, 2, 3, 0, 0),
(27, 1, 25, 9, 0, 4, 2, 2, 3),
(28, 1, 26, 9, 0, 0, 3, 2, 2),
(29, 1, 27, 2, 0, 1, 4, 2, 3),
(30, 1, 28, 20, 4, 3, 0, 1, 1),
(31, 1, 29, 1, 3, 4, 0, 2, 1),
(32, 1, 30, 18, 2, 3, 0, 0, 1),
(33, 1, 31, 20, 4, 3, 4, 3, 4),
(35, 11, 31, 20, 3, 2, 2, 2, 1),
(36, 16, 31, 20, 3, 2, 2, 2, 1),
(37, 17, 32, 12, 2, 2, 2, 2, 2),
(38, 12, 32, 15, 2, 2, 2, 2, 2),
(39, 2, 32, 15, 3, 4, 3, 2, 3),
(40, 7, 32, 14, 3, NULL, 2, 3, 3),
(41, 11, 28, 18, 4, 4, NULL, NULL, NULL),
(42, 11, 26, 8, NULL, 1, 2, NULL, 2),
(43, 11, 23, 6, 2, NULL, 1, NULL, 2);
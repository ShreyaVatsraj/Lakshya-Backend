DROP DATABASE IF EXISTS `Lakshya`;
CREATE DATABASE `Lakshya`;
USE `Lakshya`;

CREATE TABLE `Users`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Username` VARCHAR(50) NOT NULL,
    `PasswordHash` VARCHAR(500) NOT NULL,
    `UserType` VARCHAR(10) NOT NULL
);

CREATE TABLE `Students`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `FullName` VARCHAR(200) NOT NULL,
    `PhoneNumber` VARCHAR(10) NOT NULL,
    `Gender` VARCHAR(6) NOT NULL,
    `UserId` INT NOT NULL,

    CONSTRAINT `FkUserIdInStudents` FOREIGN KEY (`UserId`) REFERENCES `Users`(`Id`)
);

CREATE TABLE `Subjects`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL
);

CREATE TABLE `Exams`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Name` VARCHAR(200) NOT NULL,
    `Description` VARCHAR(1000) NOT NULL,
    `DateTime` DATETIME NOT NULL,
    `DurationInMinutes` INT NOT NULL,
    `SubjectId` INT NOT NULL,

    CONSTRAINT `FkSubjectIdInExams` FOREIGN KEY (`SubjectId`) REFERENCES `Subjects`(`Id`)
);

CREATE TABLE `Questions`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `Title` VARCHAR(500) NOT NULL,
    `Option1` VARCHAR(100) NOT NULL,
    `Option2` VARCHAR(100) NOT NULL,
    `Option3` VARCHAR(100) NOT NULL,
    `Option4` VARCHAR(100) NOT NULL,
    `CorrectOptionNumber` INT NOT NULL,
    `ExamId` INT NOT NULL,

    CONSTRAINT `FkExamIdInQuestions` FOREIGN KEY (`ExamId`) REFERENCES `Exams`(`Id`)
);

CREATE TABLE `ExamAttempts`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `TimeTakenInSeconds` INT NOT NULL,
    `WasTimedOut` INT(1) NOT NULL,
    `StudentId` INT NOT NULL,
    `ExamId` INT NOT NULL,

    CONSTRAINT `FkStudentIdInExamAttempts` FOREIGN KEY (`StudentId`) REFERENCES `Students`(`Id`),
    CONSTRAINT `FkExamIdInExamAttempts` FOREIGN KEY (`ExamId`) REFERENCES `Exams`(`Id`)
);

CREATE TABLE `Answers`
(
    `Id` INT PRIMARY KEY AUTO_INCREMENT,
    `SelectedAnswerNumber` INT NOT NULL,
    `ExamAttemptId` INT NOT NULL,
    `QuestionId` INT NOT NULL,

    CONSTRAINT `FkExamAttemptIdInAnswers` FOREIGN KEY (`ExamAttemptId`) REFERENCES `ExamAttempts`(`Id`),
    CONSTRAINT `FkQuestionIdInAnswers` FOREIGN KEY (`QuestionId`) REFERENCES `Questions`(`Id`)
);

INSERT INTO `Users` SET `Id` = 1, `Username` = 'admin', `PasswordHash` = 'admin', `UserType` = 'admin';
INSERT INTO `Subjects` VALUES 
    (1, "Maths"),
    (2, "Reasoning"),
    (3, "English"),
    (4, "Entrepreneurship"),
    (5, "General Knowledge"),
    (6, "Data Interpretation")
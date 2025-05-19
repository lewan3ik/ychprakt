-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3308
-- Время создания: Май 19 2025 г., 16:18
-- Версия сервера: 8.0.30
-- Версия PHP: 8.1.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `UniversityDB`
--

-- --------------------------------------------------------

--
-- Структура таблицы `Absence`
--

CREATE TABLE `Absence` (
  `ID` int NOT NULL,
  `StudentID` int NOT NULL,
  `LessonID` int NOT NULL,
  `Minutes` int NOT NULL,
  `ExplanationFile` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Дамп данных таблицы `Absence`
--

INSERT INTO `Absence` (`ID`, `StudentID`, `LessonID`, `Minutes`, `ExplanationFile`) VALUES
(1, 1, 1, 15, NULL),
(2, 2, 2, 30, 'объяснительная_петров.pdf'),
(3, 3, 4, 45, NULL),
(4, 4, 5, 60, 'объяснительная_кузнецов.pdf'),
(5, 5, 7, 20, NULL),
(6, 6, 8, 90, 'объяснительная_федорова.pdf'),
(7, 7, 10, 15, NULL),
(8, 8, 11, 30, NULL),
(9, 9, 13, 120, 'объяснительная_григорьев.pdf'),
(10, 10, 14, 45, NULL),
(11, 11, 16, 60, NULL),
(12, 12, 17, 30, 'объяснительная_дмитриева.pdf'),
(13, 13, 19, 15, NULL),
(14, 14, 20, 90, NULL),
(15, 15, 22, 30, 'объяснительная_тимофеев.pdf'),
(16, 16, 23, 45, NULL),
(17, 17, 25, 60, NULL),
(18, 18, 26, 120, 'объяснительная_орлова.pdf'),
(19, 19, 28, 30, NULL),
(20, 20, 29, 45, NULL);

-- --------------------------------------------------------

--
-- Структура таблицы `Class`
--

CREATE TABLE `Class` (
  `ID` int NOT NULL,
  `Date` date NOT NULL,
  `LoadID` int NOT NULL,
  `ProgramID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Class`
--

INSERT INTO `Class` (`ID`, `Date`, `LoadID`, `ProgramID`) VALUES
(1, '2023-09-01', 1, 1),
(2, '2023-09-02', 1, 2),
(3, '2023-09-03', 1, 3),
(4, '2023-09-04', 2, 1),
(5, '2023-09-05', 2, 2),
(6, '2023-09-06', 2, 3),
(7, '2023-09-07', 3, 4),
(8, '2023-09-08', 3, 5),
(9, '2023-09-09', 3, 6),
(10, '2023-09-10', 4, 4),
(11, '2023-09-11', 4, 5),
(12, '2023-09-12', 4, 6),
(13, '2023-09-13', 5, 7),
(14, '2023-09-14', 5, 8),
(15, '2023-09-15', 5, 9),
(16, '2023-09-16', 6, 7),
(17, '2023-09-17', 6, 8),
(18, '2023-09-18', 6, 9),
(19, '2023-09-19', 7, 10),
(20, '2023-09-20', 7, 11),
(21, '2023-09-21', 7, 12),
(22, '2023-09-22', 8, 10),
(23, '2023-09-23', 8, 11),
(24, '2023-09-24', 8, 12),
(25, '2023-09-25', 9, 13),
(26, '2023-09-26', 9, 14),
(27, '2023-09-27', 9, 15),
(28, '2023-09-28', 10, 13),
(29, '2023-09-29', 10, 14),
(30, '2023-09-30', 10, 15),
(31, '2023-10-01', 11, 1),
(32, '2023-10-02', 11, 2),
(33, '2023-10-03', 12, 1),
(34, '2023-10-04', 12, 2),
(35, '2023-10-05', 13, 4),
(36, '2023-10-06', 13, 5),
(37, '2023-10-07', 14, 4),
(38, '2023-10-08', 14, 5),
(39, '2023-10-09', 15, 7),
(40, '2023-10-10', 15, 8),
(41, '2023-10-11', 16, 7),
(42, '2023-10-12', 16, 8),
(43, '2023-10-13', 17, 10),
(44, '2023-10-14', 17, 11),
(45, '2023-10-15', 18, 10),
(46, '2023-10-16', 18, 11),
(47, '2023-10-17', 19, 13),
(48, '2023-10-18', 19, 14),
(49, '2023-10-19', 20, 13),
(50, '2023-10-20', 20, 14),
(51, '2025-05-17', 11, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Consultation`
--

CREATE TABLE `Consultation` (
  `ID` int NOT NULL,
  `Date` date NOT NULL,
  `GroupID` int NOT NULL,
  `TeacherID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Consultation`
--

INSERT INTO `Consultation` (`ID`, `Date`, `GroupID`, `TeacherID`) VALUES
(1, '2023-10-15', 1, 1),
(2, '2023-10-16', 2, 2),
(3, '2023-10-17', 3, 3),
(4, '2023-10-18', 4, 4),
(5, '2023-10-19', 5, 5),
(6, '2023-11-15', 1, 1),
(7, '2023-11-16', 2, 2),
(8, '2023-11-17', 3, 3),
(9, '2023-11-18', 4, 4),
(10, '2023-11-19', 5, 5),
(11, '2023-12-10', 6, 6),
(12, '2023-12-11', 7, 7),
(13, '2023-12-12', 8, 8),
(14, '2023-12-13', 9, 9),
(15, '2023-12-14', 10, 10);

-- --------------------------------------------------------

--
-- Структура таблицы `Discipline`
--

CREATE TABLE `Discipline` (
  `ID` int NOT NULL,
  `Name` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Discipline`
--

INSERT INTO `Discipline` (`ID`, `Name`) VALUES
(1, 'МДК.01.01 Разработка программных модулей'),
(2, 'МДК.01.02 Тестирование программного обеспечения'),
(3, 'МДК.01.03 Разработка мобильных приложений'),
(4, 'МДК.02.01 Инструментальные средства разработки'),
(5, 'МДК.02.02 Проектирование информационных систем'),
(6, 'ОП.01 Основы программирования'),
(7, 'ОП.02 Базы данных'),
(8, 'ОП.03 Операционные системы'),
(9, 'ОП.04 Компьютерные сети'),
(10, 'ОП.05 Информационная безопасность');

-- --------------------------------------------------------

--
-- Структура таблицы `DisciplineProgram`
--

CREATE TABLE `DisciplineProgram` (
  `ID` int NOT NULL,
  `Topic` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ClassType` enum('lecture','practice','consultation','course project','exam') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Hours` int NOT NULL,
  `DisciplineID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `DisciplineProgram`
--

INSERT INTO `DisciplineProgram` (`ID`, `Topic`, `ClassType`, `Hours`, `DisciplineID`) VALUES
(1, 'Введение в программирование', 'lecture', 2, 1),
(2, 'Основы синтаксиса Python', 'practice', 4, 1),
(3, 'Работа с функциями', 'practice', 4, 1),
(4, 'Тестирование кода', 'lecture', 2, 2),
(5, 'Unit-тесты', 'practice', 6, 2),
(6, 'Интеграционное тестирование', 'practice', 6, 2),
(7, 'Основы мобильной разработки', 'lecture', 2, 3),
(8, 'UI в мобильных приложениях', 'practice', 6, 3),
(9, 'Работа с API', 'practice', 6, 3),
(10, 'Инструменты разработчика', 'lecture', 2, 4),
(11, 'Отладка кода', 'practice', 4, 4),
(12, 'Профилирование', 'practice', 4, 4),
(13, 'Модели данных', 'lecture', 2, 5),
(14, 'ER-диаграммы', 'practice', 4, 5),
(15, 'Нормализация', 'practice', 4, 5),
(16, 'Итоговый контроль', 'exam', 2, 1),
(17, 'Защита курсового проекта', 'course project', 8, 2),
(18, 'Консультация перед экзаменом', 'consultation', 2, 3);

-- --------------------------------------------------------

--
-- Структура таблицы `Grade`
--

CREATE TABLE `Grade` (
  `ID` int NOT NULL,
  `StudentID` int NOT NULL,
  `LessonID` int NOT NULL,
  `Grade` int NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Grade`
--

INSERT INTO `Grade` (`ID`, `StudentID`, `LessonID`, `Grade`, `Date`) VALUES
(1, 1, 1, 5, '2023-09-01'),
(2, 1, 2, 4, '2023-09-02'),
(3, 1, 3, 5, '2023-09-03'),
(4, 2, 1, 4, '2023-09-01'),
(5, 2, 2, 3, '2023-09-02'),
(6, 2, 3, 4, '2023-09-03'),
(7, 3, 4, 5, '2023-09-04'),
(8, 3, 5, 5, '2023-09-05'),
(9, 3, 6, 4, '2023-09-06'),
(10, 4, 4, 3, '2023-09-04'),
(11, 4, 5, 2, '2023-09-05'),
(12, 4, 6, 3, '2023-09-06'),
(13, 5, 7, 5, '2023-09-07'),
(14, 5, 8, 4, '2023-09-08'),
(15, 5, 9, 5, '2023-09-09'),
(16, 6, 7, 4, '2023-09-07'),
(17, 6, 8, 4, '2023-09-08'),
(18, 6, 9, 3, '2023-09-09'),
(19, 7, 10, 5, '2023-09-10'),
(20, 7, 11, 5, '2023-09-11'),
(21, 7, 12, 4, '2023-09-12'),
(22, 8, 10, 3, '2023-09-10'),
(23, 8, 11, 4, '2023-09-11'),
(24, 8, 12, 3, '2023-09-12'),
(25, 9, 13, 5, '2023-09-13'),
(26, 9, 14, 5, '2023-09-14'),
(27, 9, 15, 5, '2023-09-15'),
(28, 10, 13, 4, '2023-09-13'),
(29, 10, 14, 4, '2023-09-14'),
(30, 10, 15, 3, '2023-09-15'),
(31, 11, 16, 5, '2023-09-16'),
(32, 11, 17, 4, '2023-09-17'),
(33, 11, 18, 5, '2023-09-18'),
(34, 12, 16, 3, '2023-09-16'),
(35, 12, 17, 4, '2023-09-17'),
(36, 12, 18, 3, '2023-09-18'),
(37, 13, 19, 5, '2023-09-19'),
(38, 13, 20, 5, '2023-09-20'),
(39, 13, 21, 4, '2023-09-21'),
(40, 14, 19, 4, '2023-09-19'),
(41, 14, 20, 3, '2023-09-20'),
(42, 14, 21, 4, '2023-09-21'),
(43, 15, 22, 5, '2023-09-22'),
(44, 15, 23, 5, '2023-09-23'),
(45, 15, 24, 5, '2023-09-24'),
(46, 16, 22, 4, '2023-09-22'),
(47, 16, 23, 4, '2023-09-23'),
(48, 16, 24, 3, '2023-09-24'),
(49, 17, 25, 5, '2023-09-25'),
(50, 17, 26, 5, '2023-09-26'),
(51, 17, 27, 4, '2023-09-27'),
(52, 18, 25, 4, '2023-09-25'),
(53, 18, 26, 3, '2023-09-26'),
(54, 18, 27, 4, '2023-09-27'),
(55, 19, 28, 5, '2023-09-28'),
(56, 19, 29, 5, '2023-09-29'),
(57, 19, 30, 5, '2023-09-30'),
(58, 20, 28, 4, '2023-09-28'),
(59, 20, 29, 4, '2023-09-29'),
(60, 20, 30, 3, '2023-09-30'),
(61, 4, 51, 3, '2025-05-17');

-- --------------------------------------------------------

--
-- Структура таблицы `Group`
--

CREATE TABLE `Group` (
  `ID` int NOT NULL,
  `Name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Group`
--

INSERT INTO `Group` (`ID`, `Name`) VALUES
(1, 'ИСП-21.1'),
(2, 'ИСП-21.2'),
(3, 'ИСП-21.3'),
(4, 'ИСП-21.4'),
(5, 'ИСВ-22.1'),
(6, 'ИСВ-22.2'),
(7, 'ПИ-23.1'),
(8, 'ПИ-23.2'),
(9, 'БИ-24.1'),
(10, 'БИ-24.2');

-- --------------------------------------------------------

--
-- Структура таблицы `Lesson`
--

CREATE TABLE `Lesson` (
  `ID` int NOT NULL,
  `Date` date NOT NULL,
  `WorkloadID` int NOT NULL,
  `CurriculumID` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Lesson`
--

INSERT INTO `Lesson` (`ID`, `Date`, `WorkloadID`, `CurriculumID`) VALUES
(1, '2023-09-01', 1, 1),
(2, '2023-09-02', 1, 2),
(3, '2023-09-03', 1, 3),
(4, '2023-09-04', 2, 1),
(5, '2023-09-05', 2, 2),
(6, '2023-09-06', 2, 3),
(7, '2023-09-07', 3, 4),
(8, '2023-09-08', 3, 5),
(9, '2023-09-09', 3, 6),
(10, '2023-09-10', 4, 4),
(11, '2023-09-11', 4, 5),
(12, '2023-09-12', 4, 6),
(13, '2023-09-13', 5, 7),
(14, '2023-09-14', 5, 8),
(15, '2023-09-15', 5, 9),
(16, '2023-09-16', 6, 7),
(17, '2023-09-17', 6, 8),
(18, '2023-09-18', 6, 9),
(19, '2023-09-19', 7, 10),
(20, '2023-09-20', 7, 11),
(21, '2023-09-21', 7, 12),
(22, '2023-09-22', 8, 10),
(23, '2023-09-23', 8, 11),
(24, '2023-09-24', 8, 12),
(25, '2023-09-25', 9, 13),
(26, '2023-09-26', 9, 14),
(27, '2023-09-27', 9, 15),
(28, '2023-09-28', 10, 13),
(29, '2023-09-29', 10, 14),
(30, '2023-09-30', 10, 15),
(31, '2023-10-01', 11, 1),
(32, '2023-10-02', 11, 2),
(33, '2023-10-03', 12, 1),
(34, '2023-10-04', 12, 2),
(35, '2023-10-05', 13, 4),
(36, '2023-10-06', 13, 5),
(37, '2023-10-07', 14, 4),
(38, '2023-10-08', 14, 5),
(39, '2023-10-09', 15, 7),
(40, '2023-10-10', 15, 8),
(41, '2023-10-11', 16, 7),
(42, '2023-10-12', 16, 8),
(43, '2023-10-13', 17, 10),
(44, '2023-10-14', 17, 11),
(45, '2023-10-15', 18, 10),
(46, '2023-10-16', 18, 11),
(47, '2023-10-17', 19, 13),
(48, '2023-10-18', 19, 14),
(49, '2023-10-19', 20, 13),
(50, '2023-10-20', 20, 14),
(51, '2025-05-17', 11, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Load`
--

CREATE TABLE `Load` (
  `ID` int NOT NULL,
  `TeacherID` int NOT NULL,
  `DisciplineID` int NOT NULL,
  `GroupID` int NOT NULL,
  `LectureHours` int DEFAULT '0',
  `PracticeHours` int DEFAULT '0',
  `ConsultationHours` int DEFAULT '0',
  `CourseProjectHours` int DEFAULT '0',
  `ExamHours` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Load`
--

INSERT INTO `Load` (`ID`, `TeacherID`, `DisciplineID`, `GroupID`, `LectureHours`, `PracticeHours`, `ConsultationHours`, `CourseProjectHours`, `ExamHours`) VALUES
(1, 1, 1, 1, 20, 40, 4, 8, 2),
(2, 2, 1, 2, 20, 40, 4, 8, 2),
(3, 3, 2, 3, 15, 30, 3, 6, 2),
(4, 4, 2, 4, 15, 30, 3, 6, 2),
(5, 5, 3, 5, 18, 36, 4, 8, 2),
(6, 6, 3, 6, 18, 36, 4, 8, 2),
(7, 7, 4, 7, 16, 32, 3, 6, 2),
(8, 8, 4, 8, 16, 32, 3, 6, 2),
(9, 9, 5, 9, 14, 28, 3, 6, 2),
(10, 10, 5, 10, 14, 28, 3, 6, 2),
(11, 1, 6, 1, 12, 24, 2, 4, 2),
(12, 2, 6, 2, 12, 24, 2, 4, 2),
(13, 3, 7, 3, 10, 20, 2, 4, 2),
(14, 4, 7, 4, 10, 20, 2, 4, 2),
(15, 5, 8, 5, 8, 16, 2, 4, 2),
(16, 6, 8, 6, 8, 16, 2, 4, 2),
(17, 7, 9, 7, 6, 12, 1, 2, 1),
(18, 8, 9, 8, 6, 12, 1, 2, 1),
(19, 9, 10, 9, 4, 8, 1, 2, 1),
(20, 10, 10, 10, 4, 8, 1, 2, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `Student`
--

CREATE TABLE `Student` (
  `ID` int NOT NULL,
  `FullName` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `ExpulsionDate` date DEFAULT NULL,
  `GroupID` int NOT NULL,
  `login` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Student`
--

INSERT INTO `Student` (`ID`, `FullName`, `ExpulsionDate`, `GroupID`, `login`, `password`) VALUES
(1, '', NULL, 1, 'ivan', '$2y$10$RBDZOfXrOfI0W9IvCB76yOuLfOtnwqOVTz.Xi4jP.EyrObRYYiRlG'),
(2, '', '2023-03-10', 1, '', ''),
(3, '', NULL, 2, '', ''),
(4, '', '2023-01-15', 2, '', ''),
(5, '', '2023-06-20', 3, '', ''),
(6, '', NULL, 3, '', ''),
(7, '', '2023-03-10', 4, '', ''),
(8, '', NULL, 4, '', ''),
(9, '', NULL, 5, '', ''),
(10, '', NULL, 5, '', ''),
(11, '', NULL, 6, '', ''),
(12, '', '2023-06-20', 6, '', ''),
(13, '', NULL, 7, '', ''),
(14, '', NULL, 7, '', ''),
(15, '', '2023-03-10', 8, '', ''),
(16, '', NULL, 8, '', ''),
(17, '', NULL, 9, '', ''),
(18, '', '2023-06-20', 9, '', ''),
(19, '', NULL, 10, '', ''),
(20, '', NULL, 10, '', '');

-- --------------------------------------------------------

--
-- Структура таблицы `Teacher`
--

CREATE TABLE `Teacher` (
  `ID` int NOT NULL,
  `FullName` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Login` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `Password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Teacher`
--

INSERT INTO `Teacher` (`ID`, `FullName`, `Login`, `Password`) VALUES
(1, 'Иванов Петр Сергеевич', 'ivanov_ps', '$2y$10$RBDZOfXrOfI0W9IvCB76yOuLfOtnwqOVTz.Xi4jP.EyrObRYYiRlG'),
(2, 'Петрова Анна Михайловна', 'petrova_am', '$2y$10$uX/fJbdFuvhgsIzd1HeAyOWAK9Q3OUffnU9VlFNqXp60v3OjTCrV2'),
(3, 'Сидоров Алексей Владимирович', 'sidorov_av', 'asdfgh789'),
(4, 'Кузнецова Елена Дмитриевна', 'kuznetsova_ed', 'zxcvbn123'),
(5, 'Васильев Денис Олегович', 'vasilev_do', 'pass123word'),
(6, 'Смирнова Ольга Игоревна', 'smirnova_oi', 'olga2023'),
(7, 'Федоров Михаил Александрович', 'fedorov_ma', 'misha456'),
(8, 'Николаева Татьяна Сергеевна', 'nikolaeva_ts', 'tanya789'),
(9, 'Алексеев Андрей Петрович', 'alekseev_ap', 'andrey123'),
(10, 'Павлова Юлия Викторовна', 'pavlova_yv', 'julia456');

-- --------------------------------------------------------

--
-- Структура таблицы `Workload`
--

CREATE TABLE `Workload` (
  `ID` int NOT NULL,
  `TeacherID` int NOT NULL,
  `DisciplineID` int NOT NULL,
  `GroupID` int NOT NULL,
  `LectureHours` int DEFAULT '0',
  `PracticeHours` int DEFAULT '0',
  `ConsultationHours` int DEFAULT '0',
  `CourseworkHours` int DEFAULT '0',
  `ExamHours` int DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `Workload`
--

INSERT INTO `Workload` (`ID`, `TeacherID`, `DisciplineID`, `GroupID`, `LectureHours`, `PracticeHours`, `ConsultationHours`, `CourseworkHours`, `ExamHours`) VALUES
(1, 1, 1, 1, 20, 40, 4, 8, 2),
(2, 2, 1, 2, 20, 40, 4, 8, 2),
(3, 3, 2, 3, 15, 30, 3, 6, 2),
(4, 4, 2, 4, 15, 30, 3, 6, 2),
(5, 5, 3, 5, 18, 36, 4, 8, 2),
(6, 6, 3, 6, 18, 36, 4, 8, 2),
(7, 7, 4, 7, 16, 32, 3, 6, 2),
(8, 8, 4, 8, 16, 32, 3, 6, 2),
(9, 9, 5, 9, 14, 28, 3, 6, 2),
(10, 10, 5, 10, 14, 28, 3, 6, 2),
(11, 1, 6, 1, 12, 24, 2, 4, 2),
(12, 2, 6, 2, 12, 24, 2, 4, 2),
(13, 3, 7, 3, 10, 20, 2, 4, 2),
(14, 4, 7, 4, 10, 20, 2, 4, 2),
(15, 5, 8, 5, 8, 16, 2, 4, 2),
(16, 6, 8, 6, 8, 16, 2, 4, 2),
(17, 7, 9, 7, 6, 12, 1, 2, 1),
(18, 8, 9, 8, 6, 12, 1, 2, 1),
(19, 9, 10, 9, 4, 8, 1, 2, 1),
(20, 10, 10, 10, 4, 8, 1, 2, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `Absence`
--
ALTER TABLE `Absence`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_absence_student` (`StudentID`),
  ADD KEY `idx_absence_lesson` (`LessonID`);

--
-- Индексы таблицы `Class`
--
ALTER TABLE `Class`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `ProgramID` (`ProgramID`),
  ADD KEY `idx_class_date` (`Date`),
  ADD KEY `idx_class_load` (`LoadID`);

--
-- Индексы таблицы `Consultation`
--
ALTER TABLE `Consultation`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `TeacherID` (`TeacherID`),
  ADD KEY `idx_consultation_group` (`GroupID`),
  ADD KEY `idx_consultation_date` (`Date`);

--
-- Индексы таблицы `Discipline`
--
ALTER TABLE `Discipline`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `DisciplineProgram`
--
ALTER TABLE `DisciplineProgram`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_program_discipline` (`DisciplineID`);

--
-- Индексы таблицы `Grade`
--
ALTER TABLE `Grade`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_grade_student` (`StudentID`),
  ADD KEY `idx_grade_lesson` (`LessonID`),
  ADD KEY `idx_grade_date` (`Date`);

--
-- Индексы таблицы `Group`
--
ALTER TABLE `Group`
  ADD PRIMARY KEY (`ID`);

--
-- Индексы таблицы `Lesson`
--
ALTER TABLE `Lesson`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `CurriculumID` (`CurriculumID`),
  ADD KEY `idx_lesson_date` (`Date`),
  ADD KEY `idx_lesson_workload` (`WorkloadID`);

--
-- Индексы таблицы `Load`
--
ALTER TABLE `Load`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_load_teacher` (`TeacherID`),
  ADD KEY `idx_load_discipline` (`DisciplineID`),
  ADD KEY `idx_load_group` (`GroupID`);

--
-- Индексы таблицы `Student`
--
ALTER TABLE `Student`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_student_group` (`GroupID`),
  ADD KEY `idx_student_active` (`ExpulsionDate`);

--
-- Индексы таблицы `Teacher`
--
ALTER TABLE `Teacher`
  ADD PRIMARY KEY (`ID`),
  ADD UNIQUE KEY `Login` (`Login`);

--
-- Индексы таблицы `Workload`
--
ALTER TABLE `Workload`
  ADD PRIMARY KEY (`ID`),
  ADD KEY `idx_workload_teacher` (`TeacherID`),
  ADD KEY `idx_workload_discipline` (`DisciplineID`),
  ADD KEY `idx_workload_group` (`GroupID`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `Absence`
--
ALTER TABLE `Absence`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `Class`
--
ALTER TABLE `Class`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `Consultation`
--
ALTER TABLE `Consultation`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT для таблицы `Discipline`
--
ALTER TABLE `Discipline`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `DisciplineProgram`
--
ALTER TABLE `DisciplineProgram`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT для таблицы `Grade`
--
ALTER TABLE `Grade`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT для таблицы `Group`
--
ALTER TABLE `Group`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `Lesson`
--
ALTER TABLE `Lesson`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT для таблицы `Load`
--
ALTER TABLE `Load`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `Student`
--
ALTER TABLE `Student`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT для таблицы `Teacher`
--
ALTER TABLE `Teacher`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `Workload`
--
ALTER TABLE `Workload`
  MODIFY `ID` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `Absence`
--
ALTER TABLE `Absence`
  ADD CONSTRAINT `absence_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`ID`),
  ADD CONSTRAINT `absence_ibfk_2` FOREIGN KEY (`LessonID`) REFERENCES `Lesson` (`ID`);

--
-- Ограничения внешнего ключа таблицы `Consultation`
--
ALTER TABLE `Consultation`
  ADD CONSTRAINT `consultation_ibfk_1` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`ID`),
  ADD CONSTRAINT `consultation_ibfk_2` FOREIGN KEY (`TeacherID`) REFERENCES `Teacher` (`ID`);

--
-- Ограничения внешнего ключа таблицы `Grade`
--
ALTER TABLE `Grade`
  ADD CONSTRAINT `grade_ibfk_1` FOREIGN KEY (`StudentID`) REFERENCES `Student` (`ID`),
  ADD CONSTRAINT `grade_ibfk_2` FOREIGN KEY (`LessonID`) REFERENCES `Lesson` (`ID`);

--
-- Ограничения внешнего ключа таблицы `Load`
--
ALTER TABLE `Load`
  ADD CONSTRAINT `load_ibfk_1` FOREIGN KEY (`TeacherID`) REFERENCES `Teacher` (`ID`),
  ADD CONSTRAINT `load_ibfk_2` FOREIGN KEY (`DisciplineID`) REFERENCES `Discipline` (`ID`),
  ADD CONSTRAINT `load_ibfk_3` FOREIGN KEY (`GroupID`) REFERENCES `Group` (`ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

CREATE DATABASE lesson;
USE lesson;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    language_level VARCHAR(20) DEFAULT 'Beginner'
);

CREATE TABLE lessons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    content TEXT NOT NULL,
    level VARCHAR(20) NOT NULL
);

CREATE TABLE exercises (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    question VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);

CREATE TABLE quizzes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lesson_id INT NOT NULL,
    question VARCHAR(255) NOT NULL,
    correct_answer VARCHAR(255) NOT NULL,
    options TEXT NOT NULL,
    FOREIGN KEY (lesson_id) REFERENCES lessons(id) ON DELETE CASCADE
);


INSERT INTO lessons (title, content, level) VALUES
('Introduction to Spanish', 'Welcome to your first Spanish lesson. Here, we will cover basic greetings and introductions.', 'Beginner'),
('Spanish Verbs - Present Tense', 'In this lesson, we will learn about conjugating regular verbs in the present tense.', 'Beginner'),
('Advanced Vocabulary', 'This lesson will cover advanced vocabulary for professional and social situations.', 'Advanced');

INSERT INTO exercises (lesson_id, question, correct_answer) VALUES
(1, 'How do you say "Hello" in Spanish?', 'Hola'),
(1, 'How do you say "Goodbye" in Spanish?', 'Adiós'),
(2, 'What is the "yo" form of the verb "hablar" (to speak) in the present tense?', 'Hablo'),
(2, 'What is the "tú" form of the verb "comer" (to eat) in the present tense?', 'Comes'),
(3, 'Translate "negotiation" to Spanish.', 'negociación'),
(3, 'Translate "collaboration" to Spanish.', 'colaboración');

INSERT INTO quizzes (lesson_id, question, correct_answer, options) VALUES
(1, 'What is the correct translation for "Good morning"?', 'Buenos días', 'Buenos días,Buenas noches,Buenas tardes'),
(1, 'How do you say "Thank you" in Spanish?', 'Gracias', 'Por favor,De nada,Gracias'),
(2, 'What is the "nosotros" form of the verb "vivir" (to live) in the present tense?', 'Vivimos', 'Vivimos,Viven,Vivo'),
(2, 'What is the "él/ella" form of the verb "escribir" (to write) in the present tense?', 'Escribe', 'Escribo,Escribes,Escribe'),
(3, 'Translate "efficiency" to Spanish.', 'eficiencia', 'eficiencia,efectividad,productividad'),
(3, 'Translate "strategy" to Spanish.', 'estrategia', 'estrategia,táctica,planificación');

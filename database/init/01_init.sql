-- Создаем таблицу пользователей
CREATE TABLE IF NOT EXISTS posts (
    id SERIAL PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Добавляем тестовые данные
INSERT INTO users (username, email) VALUES 
    ('admin', 'admin@example.com'),
    ('test_user', 'test@example.com');
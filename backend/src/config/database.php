<?php
class Database {
    private static $instance = null;
    
    // 1. Объявляем свойство $conn явно
    private $conn = null; 

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $port;

    private function __construct() {
        $this->host = getenv('DB_HOST') ?: 'db';
        $this->port = getenv('DB_PORT') ?: '5432';
        $this->db_name = getenv('POSTGRES_DB') ?: 'myapp_db';
        $this->username = getenv('POSTGRES_USER') ?: 'myapp_user';
        $this->password = getenv('POSTGRES_PASSWORD') ?: 'myapp_secret_password';
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection() {
        // Если соединение уже есть, возвращаем его
        if ($this->conn !== null) {
            return $this->conn;
        }

        // 2. Убираем charset из DSN для PostgreSQL
        $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
        
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            // Отключаем авто-коммит, если нужно управлять транзакциями вручную (опционально)
            // PDO::ATTR_AUTOCOMMIT => false, 
        ];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
            
            // 3. Устанавливаем кодировку UTF-8 явно для PostgreSQL
            $this->conn->exec("SET NAMES 'utf8'");
            $this->conn->exec("SET CLIENT_ENCODING TO 'UTF8'");
            
        } catch(PDOException $e) {
            // Логируем техническую ошибку в файл логов PHP/контейнера
            error_log("Database connection error: " . $e->getMessage());
            
            http_response_code(500);
            // Возвращаем JSON и завершаем скрипт
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Database connection failed']);
            exit; // exit надежнее, чем die, в контексте API
        }
        
        return $this->conn;
    }
    
    public function closeConnection() {
        $this->conn = null;
        self::$instance = null;
    }
}
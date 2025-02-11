$host = 'localhost';
$dbname = 'ITdescription';
$user = 'postgres';  // Use your PostgreSQL username
$pass = 'Butterfly!17';
$port = 5432;  // PostgreSQL default port
$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    echo "✅ Successfully connected to PostgreSQL!";
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

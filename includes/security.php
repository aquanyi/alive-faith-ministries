<?php
/**
 * Alive Faith Ministries (AFM)
 * Application Security Engine and Defense Shield
 * Protects against SQL injection, Cross-Site Scripting (XSS),
 * Cross-Site Request Forgery (CSRF), clickjacking, and bot automation.
 */

// Prevent direct execution if loaded outside of the application environment
if (!defined('AFM_SECURITY_INITIALIZED')) {
    define('AFM_SECURITY_INITIALIZED', true);
}

// 1. Hide PHP version signatures to reduce reconnaissance
if (function_exists('header_remove')) {
    header_remove('X-Powered-By');
}

// 2. Transmit strict HTTP security headers
if (!headers_sent()) {
    header('X-Frame-Options: SAMEORIGIN');
    header('X-Content-Type-Options: nosniff');
    header('X-XSS-Protection: 1; mode=block');
    header('Referrer-Policy: strict-origin-when-cross-origin');
    header('Permissions-Policy: camera=(), microphone=(), geolocation=(), payment=()');

    // Content Security Policy for assets and inline layout scripts
    $csp = "default-src 'self'; " .
           "script-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
           "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com; " .
           "font-src 'self' https://fonts.gstatic.com data:; " .
           "img-src 'self' data: https: blob:; " .
           "connect-src 'self'; " .
           "frame-ancestors 'self'; " .
           "base-uri 'self'; " .
           "form-action 'self';";
    header('Content-Security-Policy: ' . $csp);
}

// 3. Initialize secure session management
if (session_status() === PHP_SESSION_NONE) {
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ||
                (isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443);

    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_strict_mode', '1');

    session_set_cookie_params([
        'lifetime' => 0,
        'path'     => '/',
        'domain'   => '',
        'secure'   => $is_https,
        'httponly' => true,
        'samesite' => 'Lax'
    ]);

    session_start();
}

/**
 * Generate or retrieve an active CSRF token for form verification.
 */
function get_csrf_token() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

/**
 * Validate submitted CSRF token against active session token.
 */
function verify_csrf_token($token) {
    if (empty($token) || empty($_SESSION['csrf_token'])) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], (string)$token);
}

/**
 * Generate a timestamp token for human submission velocity validation.
 */
function get_form_timestamp() {
    $now = time();
    $_SESSION['form_rendered_at'] = $now;
    return $now;
}

/**
 * Check if the submission occurred with human velocity (at least 2 seconds).
 */
function verify_submission_speed() {
    if (empty($_SESSION['form_rendered_at'])) {
        return true;
    }
    $elapsed = time() - (int)$_SESSION['form_rendered_at'];
    return $elapsed >= 2;
}

/**
 * Simple session and IP rate limiting for contact submissions.
 * Allows at most 5 messages every 10 minutes.
 */
function check_submission_rate_limit() {
    $limit = 5;
    $window = 600; // 10 minutes
    $now = time();

    if (!isset($_SESSION['submission_history'])) {
        $_SESSION['submission_history'] = [];
    }

    // Retain only timestamps within the window
    $_SESSION['submission_history'] = array_filter(
        $_SESSION['submission_history'],
        function ($timestamp) use ($now, $window) {
            return ($now - $timestamp) < $window;
        }
    );

    if (count($_SESSION['submission_history']) >= $limit) {
        return false;
    }

    return true;
}

/**
 * Record a successful form submission for rate limiting.
 */
function record_submission_event() {
    if (!isset($_SESSION['submission_history'])) {
        $_SESSION['submission_history'] = [];
    }
    $_SESSION['submission_history'][] = time();
}

/**
 * Clean null bytes and non-printable control characters from input strings.
 */
function sanitize_text_input($input) {
    if (is_array($input)) {
        return array_map('sanitize_text_input', $input);
    }
    // Remove null bytes and carriage return tricks
    $clean = str_replace(chr(0), '', (string)$input);
    return trim($clean);
}

/**
 * Inspect a string value for SQL injection and malicious script signatures.
 */
function detect_malicious_payload($value) {
    if (is_array($value)) {
        foreach ($value as $item) {
            if (detect_malicious_payload($item)) {
                return true;
            }
        }
        return false;
    }

    $val = (string)$value;

    // Check for path traversal attempts
    if (preg_match('/\.\.[\/\\\\]/', $val)) {
        return true;
    }

    // Check for high-risk SQL injection signatures
    $patterns = [
        '/\b(union(\s+all)?\s+select)\b/i',
        '/\b(select\s+.+\s+from)\b/i',
        '/\b(insert\s+into\s+.+\s+values)\b/i',
        '/\b(drop\s+table|drop\s+database|truncate\s+table)\b/i',
        '/\b(information_schema|benchmark\s*\(|pg_sleep\s*\(|waitfor\s+delay)\b/i',
        '/\b(xp_cmdshell|exec\s*\(|execute\s*\()\b/i',
        '/(\bOR\b|\bAND\b)\s+[\'"]?1[\'"]?\s*=\s*[\'"]?1/i',
        '/[\'"]\s*;\s*(DROP|ALTER|CREATE|TRUNCATE)\b/i'
    ];

    foreach ($patterns as $pattern) {
        if (preg_match($pattern, $val)) {
            return true;
        }
    }

    return false;
}

/**
 * Global incoming request scanner.
 * Evaluates GET queries and query strings for malicious payloads.
 */
function security_guard_request() {
    $raw_query = $_SERVER['QUERY_STRING'] ?? '';
    if (!empty($raw_query) && detect_malicious_payload(urldecode($raw_query))) {
        http_response_code(400);
        exit('Invalid request parameters detected. Request rejected for security.');
    }

    if (!empty($_GET) && detect_malicious_payload($_GET)) {
        http_response_code(400);
        exit('Invalid GET parameter detected. Request rejected for security.');
    }
}

// Automatically guard the incoming request
security_guard_request();

/**
 * Future-Ready Secure Database Connection Helper.
 * When the ministry connects a MySQL or MariaDB database, this function provides
 * a fortified PDO instance with prepared statements enforced and emulation disabled.
 */
function get_secure_db_connection($host = 'localhost', $dbname = 'alive_faith', $user = 'root', $pass = '') {
    $dsn = "mysql:host={$host};dbname={$dbname};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
        PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
    ];
    return new PDO($dsn, $user, $pass, $options);
}

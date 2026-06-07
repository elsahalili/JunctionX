<?php
declare(strict_types=1);

const APP_NAME = 'UniMatch';
const APP_SUPPORT_EMAIL = 'admissions@unimatch.test';
const APP_SUPPORT_PHONE = '+355 69 000 0000';
const APP_ADDRESS = 'Tirana Business University, Tirana, Albania';

function app_path(string $path = ''): string
{
    return __DIR__ . ($path !== '' ? DIRECTORY_SEPARATOR . ltrim($path, '/\\') : '');
}

function app_read_json(string $path, mixed $default = []): mixed
{
    if (!is_file($path)) {
        return $default;
    }

    $data = json_decode((string) file_get_contents($path), true);
    return json_last_error() === JSON_ERROR_NONE ? $data : $default;
}

function app_write_json(string $path, mixed $data): bool
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }

    return file_put_contents(
        $path,
        json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE),
        LOCK_EX
    ) !== false;
}

function app_safe_user_filename(string $email): string
{
    $safeEmail = preg_replace('/[^a-z0-9]+/i', '_', strtolower(trim($email)));
    return trim((string) $safeEmail, '_') . '.json';
}

function app_current_user_file(): ?string
{
    $sessionFile = $_SESSION['user']['file'] ?? null;
    if (is_string($sessionFile) && $sessionFile !== '') {
        $basename = basename($sessionFile);
        return app_path('users_data/' . $basename);
    }

    $email = $_SESSION['user']['email'] ?? $_SESSION['email'] ?? null;
    if (!is_string($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return null;
    }

    return app_path('users_data/' . app_safe_user_filename($email));
}

function app_public_user_file(?string $email = null): string
{
    $email = $email ?: ($_SESSION['user']['email'] ?? 'guest@example.com');
    return 'users_data/' . app_safe_user_filename($email);
}

function app_redirect(string $location): never
{
    header('Location: ' . $location);
    exit;
}

function app_h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

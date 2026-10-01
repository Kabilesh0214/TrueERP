<?php
class Logger
{
    public static function log(string $level, string $message, array $context = []): void
    {
        $dir = BASE_PATH . '/storage/logs';
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        $file = $dir . '/app-' . date('Y-m-d') . '.log';
        $time = date('Y-m-d H:i:s');
        $ctx = !empty($context) ? ' ' . json_encode($context) : '';
        file_put_contents($file, "[{$time}] [{$level}] {$message}{$ctx}" . PHP_EOL, FILE_APPEND);
    }

    public static function info(string $msg, array $ctx = []): void { self::log('INFO', $msg, $ctx); }
    public static function error(string $msg, array $ctx = []): void { self::log('ERROR', $msg, $ctx); }
}

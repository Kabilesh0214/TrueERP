<?php
class NotificationService
{
    public static function notify(string $type, string $message, ?int $userId = null): void
    {
        Logger::info("Notification [{$type}]: {$message}", ['user_id' => $userId]);
    }
}

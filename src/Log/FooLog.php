<?php 
// src/Log/FooLog.php

namespace App\Log;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class FooLog
{
    private static $translator;
    private static $logger;

    public static function setTranslator(TranslatorInterface $translator)
    {
        self::$translator = $translator;
    }

    public static function setLogger(LoggerInterface $logger)
    {
        self::$logger = $logger;
    }

    public static function logTitle(string $lang, string $title)
    {
        $translatedTitle = self::translate($title, $lang);
        self::$logger->info($translatedTitle);
    }

    public static function logMessage(string $lang, string $message)
    {
        $translatedMessage = self::translate($message, $lang);
        self::$logger->info($translatedMessage);
    }

    private static function translate(string $message, string $lang): string
    {
        // Utilisez le service de traduction pour traduire le message
        if (self::$translator !== null) {
            return self::$translator->trans($message, [], 'messages', $lang);
        }

        // Si le service de traduction n'est pas disponible, retournez le message d'origine
        return $message;
    }
}
?>
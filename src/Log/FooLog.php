<?php 
namespace App\Log;
use Symfony\Contracts\Translation\TranslatorInterface;

class FooLog
{
    private static $translator;
    private static $logtitle;

    public static function setTranslator(TranslatorInterface $translator)
    {
        self::$translator = $translator;
    }

    public static function logTitle(string $lang, string $title)
    {
        $translatedTitle = self::translate($title, $lang);
        self::$logtitle = $translatedTitle;
    }

    public static function logMessage(string $lang, string $message)
    {
        $translatedMessage = self::translate($message, $lang);
        file_put_contents("../src/log/dev.log", self::$logtitle." : ".$translatedMessage."\n", FILE_APPEND);
    }

    private static function translate(string $message, string $lang): string
    {
        if (self::$translator !== null) {
            return self::$translator->trans($message, [], 'messages', $lang);
        }
        return $message;
    }
}
?>
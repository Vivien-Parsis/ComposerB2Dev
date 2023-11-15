<?php 
    namespace App\Validator;
    use App\Log\FooLog;
    
    class ComposerValidator
    {
        public static function validate(string $composerPath, string $lang = 'en'): array
        {
            $composerContent = json_decode(file_get_contents($composerPath), true);
            if ($composerContent === null) {
                throw new \InvalidArgumentException('composer.json is empty or invalid JSON.');
            }
            $nameValid = self::validateName($composerContent['name']);
            $descriptionValid = self::validateDescription($composerContent['description']);
            $requireValid = self::validateRequire($composerContent['require']);
            $versionValid = self::validateVersion($composerContent['require']['php']);
            return [
                'name' => $nameValid,
                'description' => $descriptionValid,
                'require' => $requireValid,
                'version' => $versionValid,
            ];
        }
    
        private static function validateName(string $name): bool{
            return !empty($name);
        }
    
        private static function validateDescription(string $description): bool{
            return !empty($description);
        }
    
        private static function validateRequire(array $require): bool{
            return !empty($require);
        }
    
        private static function validateVersion(string $version): bool{
            return !empty($version);
        }
    }
?>
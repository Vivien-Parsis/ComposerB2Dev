<?php 
    namespace App\Validator;
    
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
            return !trim($name)==""&&str_contains($name,"/")&&!str_contains($name," ");
        }
    
        private static function validateDescription(string $description): bool{
            return !trim($description)=="";
        }
    
        private static function validateRequire(array $require): bool{
            return !empty($require);
        }
    
        private static function validateVersion(string $version): bool{
            return !(trim($version)==""||preg_match("/[a-z]/i", $version));
        }
    }
?>
<?php 
namespace App\Command;

use App\Validator\ComposerValidator;
use App\Log\FooLog;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'composer:validate',
    description: 'Validate a composer.json file'
)]
class ComposerValidateCommand extends Command
{
    private $translator;
    private $logger;
    
    public function __construct(TranslatorInterface $translator, LoggerInterface $logger)
    {
        parent::__construct();
        $this->translator = $translator;
        $this->logger = $logger;
    }

    protected static $defaultName = 'composer:validate';

    protected function configure():void
    {
        $this
            ->setDescription('Validate a composer.json file and generate log')
            ->addArgument('composerPath', InputArgument::REQUIRED, 'Path to the composer.json file')
            ->addOption('lang', null, InputArgument::OPTIONAL, 'Language for logs (th, en, ch)', 'en');
    }

    protected function execute(InputInterface $input, OutputInterface $output):int
    {
        $composerPath = $input->getArgument('composerPath');
        $lang = $input->getOption('lang');

        $langs = ['fr', 'en', 'de'];
        $langMessage = ['fr'=>[
            'name'=> 'nom',
            'description'=>'description',
            'version'=>'version',
            'Require'=>'requise',
            'valid'=>'valide'
        ],
        'en'=>[
            'name'=> 'name',
            'description'=>'description',
            'version'=>'version',
            'Require'=>'require',
            'valid'=>'valid'
        ],
        'de'=>[
            'name'=> 'name',
            'description'=>'Beschreibung',
            'version'=>'Ausführung',
            'Require'=>'erfordern',
            'valid'=>'stichhaltig'
        ]];

        if (!in_array($lang, $langs)) {
            $errorMessage = $this->translator->trans(
                'invalid_language_code',
                ['%supported_languages%' => implode(', ', $langs)],
                'messages',
                $lang
            );
            $output->writeln($errorMessage);
            return Command::FAILURE;
        }

        // Valider le composer.json
        // Valider le composer.json
        $validationResults = ComposerValidator::validate($composerPath, $lang);
        // Log les résultats de validation
        FooLog::setLogger($this->logger);
        FooLog::logTitle($lang, 'Validation Results');
        FooLog::logMessage($lang, $langMessage[$lang]['name'] .' '. ($validationResults['name'] ? 'Valid' : 'Invalid'));
        FooLog::logMessage($lang, $langMessage[$lang]['description'] .' '. ($validationResults['description'] ? 'Valid' : 'Invalid'));
        FooLog::logMessage($lang, $langMessage[$lang]['Require'] .' '. ($validationResults['require'] ? 'Valid' : 'Invalid'));
        FooLog::logMessage($lang, $langMessage[$lang]['version'] .' '. ($validationResults['version'] ? 'Valid' : 'Invalid'));

        return Command::SUCCESS;
    }
}
?>
<?php 
namespace App\Command;

use App\Validator\ComposerValidator;
use App\Log\FooLog;
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
    
    public function __construct(TranslatorInterface $translator)
    {
        parent::__construct();
        $this->translator = $translator;
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
            'valid'=>'valide',
            'invalid'=>'invalide'
        ],
        'en'=>[
            'name'=> 'name',
            'description'=>'description',
            'version'=>'version',
            'Require'=>'require',
            'valid'=>'valid',
            'invalid'=>'invalid'
        ],
        'de'=>[
            'name'=> 'name',
            'description'=>'Beschreibung',
            'version'=>'Ausführung',
            'Require'=>'erfordern',
            'valid'=>'stichhaltig',
            'invalid'=>'ungültig'
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
        $validationResults = ComposerValidator::validate($composerPath, $lang);
        FooLog::logTitle($lang, 'Validation Results');
        FooLog::logMessage($lang, $langMessage[$lang]['name'] .' '. ($validationResults['name'] ? $langMessage[$lang]['valid'] : $langMessage[$lang]['invalid']));
        FooLog::logMessage($lang, $langMessage[$lang]['description'] .' '. ($validationResults['description'] ? $langMessage[$lang]['valid'] : $langMessage[$lang]['invalid']));
        FooLog::logMessage($lang, $langMessage[$lang]['Require'] .' '. ($validationResults['require'] ? $langMessage[$lang]['valid'] : $langMessage[$lang]['invalid']));
        FooLog::logMessage($lang, $langMessage[$lang]['version'] .' '. ($validationResults['version'] ? $langMessage[$lang]['valid'] : $langMessage[$lang]['invalid']));

        return Command::SUCCESS;
    }
}
?>
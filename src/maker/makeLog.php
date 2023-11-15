<?php

    namespace App\makeLog;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\Generator as MakerBundleGenerator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Input\InputInterface;

    final class makeLog extends AbstractMaker{
        public static function getCommandName():string{return"";}
        public static function getCommandDescription():string{return "";}
        public function generate(InputInterface $input, ConsoleStyle $io, MakerBundleGenerator $generator)
        {
            $io->comment("");
        }
        public function configureCommand(\Symfony\Component\Console\Command\Command $command, InputConfiguration $inputConfig) : void{
            
        }
        public function configureDependencies(\Symfony\Bundle\MakerBundle\DependencyBuilder $dependencies){
            
        }
    } 

?>
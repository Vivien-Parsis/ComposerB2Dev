<?php

    namespace App\makeLog;

use Symfony\Bundle\MakerBundle\ConsoleStyle;
use Symfony\Bundle\MakerBundle\Generator as MakerBundleGenerator;
use Symfony\Bundle\MakerBundle\InputConfiguration;
use Symfony\Bundle\MakerBundle\Maker\AbstractMaker;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\MakerBundle\DependencyBuilder;

    final class makeLog extends AbstractMaker{
        public static function getCommandName():string{
            return "make:log";
        }
        public static function getCommandDescription():string{
            return "return a maker log boilerplate";
        }
        public function generate(InputInterface $input, ConsoleStyle $io, MakerBundleGenerator $generator){
            
        }
        public function configureCommand(Command $command, InputConfiguration $inputConfig) : void{
            
        }
        public function configureDependencies(DependencyBuilder $dependencies){
            
        }
    } 

?>
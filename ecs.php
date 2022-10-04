<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Comment\HashToSlashCommentFixer;
use PhpCsFixer\Fixer\Import\OrderedImportsFixer;
use PhpCsFixer\Fixer\Import\SingleImportPerStatementFixer;
use PhpCsFixer\Fixer\Operator\NotOperatorWithSuccessorSpaceFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocAddMissingParamAnnotationFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocOrderFixer;
use PhpCsFixer\Fixer\Phpdoc\PhpdocSeparationFixer;
use PhpCsFixer\Fixer\Strict\StrictComparisonFixer;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $services = $containerConfigurator->services();

    $services->set(OrderedImportsFixer::class)
        ->call('configure', [['sort_algorithm' => 'alpha']]);

    $services->set(PhpdocAddMissingParamAnnotationFixer::class);

    $services->set(PhpdocOrderFixer::class);

    $services->set(HashToSlashCommentFixer::class);

    $services->set(SingleImportPerStatementFixer::class);

    $services->set(NotOperatorWithSuccessorSpaceFixer::class);

    $services->set(PhpdocSeparationFixer::class);

    $parameters = $containerConfigurator->parameters();

    $parameters->set('sets', ['psr12']);

    $parameters->set('paths', [__DIR__.'/app']);

    $parameters->set('skip', [StrictComparisonFixer::class => null]);
};

<?php declare(strict_types=1);

namespace Kiboko\Cloud\Domain\Stack\OroPlatform\Service;

use Kiboko\Cloud\Domain\Stack\Compose\EnvironmentVariable;
use Kiboko\Cloud\Domain\Stack\Compose\PortMapping;
use Kiboko\Cloud\Domain\Stack\Compose\Service;
use Kiboko\Cloud\Domain\Stack\Compose\Variable;
use Kiboko\Cloud\Domain\Stack\Compose\VolumeMapping;
use Kiboko\Cloud\Domain\Stack\DTO;
use Kiboko\Cloud\Domain\Stack\Resource;
use Kiboko\Cloud\Domain\Stack\ServiceBuilderInterface;
use Composer\Semver\Semver;

final class Kibana implements ServiceBuilderInterface
{
    private string $stacksPath;

    public function __construct(string $stacksPath)
    {
        $this->stacksPath = $stacksPath;
    }

    public function matches(DTO\Context $context): bool
    {
        return $context->withElasticStack === true;
    }

    private function buildImageTag(DTO\Context $context)
    {
        if (Semver::satisfies($context->applicationVersion, '^3.0')) {
            return 'docker.elastic.co/kibana/kibana:6.8.11';
        }

        if (Semver::satisfies($context->applicationVersion, '^4.0')) {
            return 'docker.elastic.co/kibana/kibana:7.8.1';
        }

        throw new \RuntimeException('No image satisfies the application version constraint.');
    }

    public function build(DTO\Stack $stack, DTO\Context $context): DTO\Stack
    {
        $stack->addServices(
            (new Service('kibana', $this->buildImageTag($context)))
                ->addEnvironmentVariables(
                    new EnvironmentVariable(new Variable('monitoring.elasticsearch.hosts'), 'http://elasticsearch:9200'),
                )
                ->addPorts(
                    new PortMapping(new Variable('KIBANA_PORT'), 5601)
                )
                ->addVolumeMappings(
                    new VolumeMapping('./.docker/kibana/kibana.yml', '/usr/share/kibana/config/kibana.yml'),
                )
                ->setRestartOnFailure()
                ->addDependencies('elasticsearch'),
            )
        ;

        $stack->addFiles(
            new Resource\InMemory('.docker/kibana/kibana.yml', <<<EOF
                server.port: 5601
                server.host: "0.0.0.0"
                elasticsearch.hosts: "http://elasticsearch:9200"
                EOF),
        );

        $stack->addEnvironmentVariables(
            new EnvironmentVariable(new Variable('KIBANA_PORT')),
        );

        return $stack;
    }
}
<?php

namespace FriendsOfBehat\CrossContainerExtension;

use Symfony\Component\DependencyInjection\Reference;

/**
 * @internal
 */
final class ExternalReference
{
    /**
     * @var string
     */
    private $containerIdentifier;

    /**
     * @var string
     */
    private $serviceIdentifier;

    /**
     * @param string|Reference $identifierOrReference
     *
     * @throw \InvalidArgumentException If given argument is not an external reference.
     */
    public function __construct($identifierOrReference)
    {
        if ((bool) preg_match('/^__(?P<container_identifier>.+?)__\.(?P<service_identifier>.++)$/', (string) $identifierOrReference, $matches)) {
            $this->containerIdentifier = $matches['container_identifier'];
            $this->serviceIdentifier = $matches['service_identifier'];
        }

        if (null === $this->containerIdentifier || null === $this->serviceIdentifier) {
            throw new \InvalidArgumentException(sprintf(
                'Given argument "%s" is not an external reference.',
                $identifierOrReference
            ));
        }
    }

    /**
     * @param string|Reference $identifier
     *
     * @return bool
     */
    public static function isValid($identifier)
    {
        try {
            new static($identifier);

            return true;
        } catch (\InvalidArgumentException $exception) {
            return false;
        }
    }

    /**
     * @return string
     */
    public function containerIdentifier()
    {
        return $this->containerIdentifier;
    }

    /**
     * @return string
     */
    public function serviceIdentifier()
    {
        return $this->serviceIdentifier;
    }
}
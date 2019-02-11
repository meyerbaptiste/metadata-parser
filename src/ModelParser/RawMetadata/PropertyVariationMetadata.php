<?php

declare(strict_types=1);

namespace Liip\MetadataParser\ModelParser\RawMetadata;

use Liip\MetadataParser\Metadata\AbstractPropertyMetadata;
use Liip\MetadataParser\Metadata\PropertyAccessor;
use Liip\MetadataParser\Metadata\PropertyType;
use Liip\MetadataParser\Metadata\PropertyTypeUnknown;
use Liip\MetadataParser\Metadata\Version;

/**
 * A single property variant represents one item of a class that is serialized to a specific name.
 *
 * Different properties or methods with JMS serialized name annotations are considered variants of the same property.
 */
final class PropertyVariationMetadata extends AbstractPropertyMetadata
{
    /**
     * @var PropertyType
     */
    private $type;

    /**
     * @param string $name Name of the property in PHP or the method name for a virtual property
     */
    public function __construct(string $name, bool $readOnly, bool $public)
    {
        parent::__construct($name, $readOnly, $public);
        $this->type = new PropertyTypeUnknown(true);
    }

    public static function fromReflection(\ReflectionProperty $reflProperty): self
    {
        return new self($reflProperty->getName(), false, $reflProperty->isPublic());
    }

    public function setType(PropertyType $type): void
    {
        $this->type = $type;
    }

    public function getType(): PropertyType
    {
        return $this->type;
    }

    public function setPublic(bool $public): void
    {
        parent::setPublic($public);
    }

    public function setGroups(array $groups): void
    {
        parent::setGroups($groups);
    }

    public function setAccessor(PropertyAccessor $accessor): void
    {
        parent::setAccessor($accessor);
    }

    public function setVersion(Version $version): void
    {
        parent::setVersion($version);
    }

    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();
        $data['type'] = (string) $this->type;

        return $data;
    }
}

<?php

namespace App\Entity;

use App\Parser\CsvParser;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AbstractEntity
 *
 * @package App\Parser
 */
abstract class AbstractEntity
{
    /**
     * @var string $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var array $fields
     */
    private $fields;

    /**
     * @var string $fileName
     */
    protected $fileName;

    /**
     * @param AbstractEntity $entity
     * @param array $entities
     * @param array|null $fields
     */
    protected function addFieldsToEntity(AbstractEntity &$entity, array &$entities, ?array $fields) : void
    {
        if (!empty($entity)) {
            $entity->setFields($fields);
            $entities[$this->fileName][] = $entity;
        }
    }

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param string $id
     * @return static
     */
    public function setId(string $id): self
    {
        $this->id = trim($id);

        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    /**
     * @param array $fields
     * @return static
     */
    public function setFields(?array $fields): self
    {
        $this->fields = $fields;

        return $this;
    }

    /**
     * @param $values
     * @return array|null
     */
    public function fill($values) : ?array
    {
        $entities = [];
        $fields = [];
        $entity = null;

        $entityContent = CsvParser::parse($this->fileName);

        foreach ($entityContent as $entityString) {
            if (!empty($entityString['ID'])) {
                if (empty($entity)) {
                    $entity = static::create($entityString);
                }

                $fields[] = Field::create($entityString, $values);
            } elseif (empty($entityString['Post Name'])) {
                $this->addFieldsToEntity($entity, $entities, $fields);

                $fields = [];
                $entity = null;
            }
        }

        $this->addFieldsToEntity($entity, $entities, $fields);

        return $entities;
    }

    /**
     * @param array|null $fields
     * @return static|null
     */
    public static function create(?array $fields) : ?self
    {
        if (empty($fields['Post Name'])) {
            return null;
        }

        $entity = new static();
        $entity->setId($fields['ID'])
               ->setName(trim($fields['Post Name']));

        return $entity;
    }

    /**
     * @param array|null $response
     * @return array|null
     */
    public static function normalizeResponse(?array $response) : ?array
    {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $response = $serializer->normalize($response, 'json');

        return $response;
    }
}

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
        $this->id = $id;

        return $this;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;

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
     * @param $tables
     * @return array|null
     */
    public function fill($values) : ?array {

        $entities = [];
        $fields = [];
        $prevEntityName = '';

        $entityContent = CsvParser::parse($this->fileName);

        foreach ($entityContent as $entityString) {
            if ($prevEntityName !== $entityString['Display Name']) {
                $entity = static::create($entityString);
            }

            if (!empty($entityString['ID'])) {
                $fields[] = Field::create($entityString, $values);
            } else {
                if (!empty($entity)) {
                    $entity->setFields($fields);
                    $entities[$this->fileName][] = $entity;
                }

                $prevEntityName = $entityString['Display Name'];
                $entity = null;
            }
        }

        return $entities;
    }

    /**
     * @param array|null $fields
     * @return static|null
     */
    public static function create(?array $fields) : ?self {
        if (empty($fields['Display Name'])) {
            return null;
        }

        $entity = new static();
        $entity->setId($fields['ID'])
               ->setName($fields['Display Name']);

        return $entity;
    }

    /**
     * @param array|null $response
     * @return string|null
     */
    public static function serializeResponse(?array $response) : ?string {
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];

        $serializer = new Serializer($normalizers, $encoders);
        $response = $serializer->serialize($response, 'json');

        return $response;
    }
}

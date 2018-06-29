<?php

namespace App\Entity;

/**
 * Class Field
 *
 * @package App\Entity
 */
class Field
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
     * @var string $type
     */
    private $type;
    /**
     * @var array $values
     */
    private $values;

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
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getValues(): ?array
    {
        return $this->values;
    }

    /**
     * @param mixed $id
     * @return Field
     */
    public function setId(?string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @param mixed $name
     * @return Field
     */
    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param mixed $type
     * @return Field
     */
    public function setType(?string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param mixed $values
     * @param array|null $selectedValues
     * @return Field
     */
    public function setValues(?string $values, ?array $selectedValues): self
    {
        $values = strtolower($values);
        $type = $this->getType();

        if (!empty($selectedValues[$values]) && $values !== '') {
            $this->values = $selectedValues[$values];
        }

        return $this;
    }

    /**
     * @param array|null $fields
     * @param array|null $values
     * @return Field|null
     */
    public static function create(?array $fields, ?array $values = null) : ?self {
        if (empty($fields['Display Name'])) {
            return null;
        }

        $field = new Field();
        $field->setId($fields['ID'])
              ->setName($fields['Display Name'])
              ->setType($fields['Type'])
              ->setValues($fields['Tables'], $values);

        return $field;
    }
}

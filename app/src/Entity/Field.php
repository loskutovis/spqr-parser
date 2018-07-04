<?php

namespace App\Entity;

/**
 * Class Field
 *
 * @package App\Entity
 */
class Field
{
    public const ATTACHMENT_TYPE = 'attachment';
    public const CALCULATED_TYPE = 'calculated';
    public const CHECKBOX_TYPE = 'checkbox';
    public const DATE_TYPE = 'date';
    public const DROPDOWN_TYPE = 'dropdown';
    public const DROPDOWN_SINGLE_TYPE = 'dropdown single';
    public const GOOGLE_TYPE = 'google';
    public const INTEGER_TYPE = 'integer';
    public const LINK_TYPE = 'link';
    public const RADIO_BUTTON_TYPE = 'radio button';
    public const RANGE_TYPE = 'range';
    public const TEXT_TYPE = 'text';
    public const URL_TYPE = 'url';
    public const YEAR_TYPE = 'year';

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
     * @return self
     */
    public function setId(?string $id): self
    {
        $this->id = trim($id);

        return $this;
    }

    /**
     * @param mixed $name
     * @return self
     */
    public function setName(?string $name): self
    {
        $this->name = trim($name);

        return $this;
    }

    /**
     * @param mixed $type
     * @return self
     */
    public function setType(?string $type): self
    {
        $this->type = trim($type);

        return $this;
    }

    /**
     * @param mixed $values
     * @param array|null $selectedValues
     * @return self
     */
    public function setValues(?string $values, ?array $selectedValues): self
    {
        $values = trim($values);
        $values = strtolower($values);
        $type = $this->getType();

        if ($type == self::DROPDOWN_TYPE || $type == self::DROPDOWN_SINGLE_TYPE) {
            if (!empty($selectedValues[$values]) && $values !== '') {
                $this->values = $selectedValues[$values];
            } elseif (strpos($values, 'table') === false) {
                $this->values = explode(PHP_EOL, $values);
            }
        } elseif ($type == self::RANGE_TYPE) {
            $range = explode('-', $values);

            if (!empty($range[0]) && !empty($range[1])) {
                $this->values = [
                    'from' => (int) $range[0],
                    'to' => (int) $range[1]
                ];
            }
        }

        return $this;
    }

    /**
     * @param array|null $fields
     * @param array|null $values
     * @return Field|null
     */
    public static function create(?array $fields, ?array $values = null) : ?self
    {
        if (empty($fields['Display Name'])) {
            return null;
        }

        $field = new Field();
        $field->setId($fields['ID'])
              ->setName(trim($fields['Display Name']))
              ->setType($fields['Type'])
              ->setValues($fields['Tables'], $values);

        return $field;
    }
}

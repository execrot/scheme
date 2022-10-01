<?php

declare(strict_types=1);

namespace Light\Scheme;

class Collection extends AbstractMultiple
{
  /**
   * @var AbstractSingle|AbstractMultiple
   */
  protected AbstractSingle|AbstractMultiple $type;

  /**
   * @param AbstractSingle|AbstractMultiple $options
   */
  public function __construct(AbstractSingle|AbstractMultiple $type = null)
  {
    $this->type = $type;
  }

  /**
   * @param array|null $value
   * @return bool
   */
  public function isValid(?array $values): bool
  {
    $this->errors = [];

    if ($this->type instanceof AbstractSingle && !$this->type->isNullable() && !$values) {
      $this->errors[] = 'empty-value';
      return false;
    }

    foreach (($values ?? []) as $index => $value) {
      if (!$this->type->isValid($value)) {
        $this->errors[$index] = $this->type->getErrors();
      }
    }

    return !count($this->errors);
  }

  /**
   * @param array $value
   * @return array
   */
  public function normalize(?array $values): array
  {
    $data = [];

    foreach (($values ?? []) as $value) {
      $data[] = $this->type->normalize($value ?? null);
    }

    return $data;
  }
}

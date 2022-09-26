<?php

namespace Light\Scheme;

abstract class AbstractMultiple
{
  /**
   * @var array
   */
  protected array $errors = [];

  /**
   * @return array
   */
  public function getErrors(): array
  {
    return $this->errors;
  }

  /**
   * @param array|null $value
   * @return bool
   */
  abstract public function isValid(?array $value): bool;

  /**
   * @param array|null $value
   * @return array
   */
  abstract public function normalize(?array $values): array;
}
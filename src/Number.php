<?php

declare(strict_types=1);

namespace Light\Scheme;

class Number extends AbstractSingle
{
  /**
   * @param mixed $value
   * @return bool
   */
  public function isValid(mixed $value): bool
  {
    $isValid = parent::isValid($value);

    if ($value && !is_numeric($value)) {
      $this->errors[] = 'non-numeric-value';
      $isValid = false;
    }

    return $isValid;
  }

  /**
   * @param mixed $value
   * @return int|null
   */
  public function normalize(mixed $value): int|null
  {
    return intval(parent::normalize($value));
  }
}

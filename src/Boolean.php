<?php

declare(strict_types=1);

namespace Light\Scheme;

class Boolean extends AbstractSingle
{
  /**
   * @param mixed $value
   * @return bool
   */
  public function normalize(mixed $value): bool
  {
    return boolval(parent::normalize($value));
  }
}

<?php

declare(strict_types=1);

namespace Light\Scheme;

use Closure;

use Light\Utilites\Filter\FilterAbstract;
use Light\Utilites\Validator\ValidatorAbstract;

abstract class AbstractSingle
{
  /**
   * @var bool
   */
  protected bool $nullable = false;

  /**
   * @var ValidatorAbstract[]|Closure[]
   */
  protected array $validators = [];

  /**
   * @var FilterAbstract[]|Closure[]
   */
  protected array $filters = [];

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
   * @param array|null $options
   */
  public function __construct(array $options = [])
  {
    foreach ($options as $key => $value) {
      $this->{$key} = $value;
    }
  }

  /**
   * @return bool
   */
  public function isNullable(): bool
  {
    return $this->nullable;
  }

  /**
   * @param mixed $value
   * @return bool
   */
  public function isValid(mixed $value): bool
  {
    $this->errors = [];

    if ($this->nullable && !$value) {
      return true;
    }

    if (!$this->nullable && !$value) {
      $this->errors[] = 'empty-value';
      return false;
    }

    foreach ($this->filters as $filter) {
      if ($filter instanceof FilterAbstract) {
        $value = $filter->filter($value);

      } else if ($filter instanceof Closure) {
        $value = $filter($value);
      }
    }

    foreach ($this->validators as $key => $validator) {
      if ($validator instanceof ValidatorAbstract && !$validator->isValid($value)) {
        $this->errors[] = get_class($validator);

      } else if ($validator instanceof Closure && !$validator($value)) {
        $this->errors[] = 'closure-' . $key;
      }
    }

    return !count($this->errors);
  }

  /**
   * @param mixed $value
   * @return int|bool|string|array|null
   */
  public function normalize(mixed $value): int|bool|string|null|array
  {
    if ($this->nullable && !$value) {
      return null;
    }

    foreach ($this->filters as $filter) {
      if ($filter instanceof FilterAbstract) {
        $value = $filter->filter($value);

      } else if ($filter instanceof Closure) {
        $value = $filter($value);
      }
    }

    return $value;
  }
}

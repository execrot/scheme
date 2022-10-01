<?php

declare(strict_types=1);

namespace Light\Scheme;

class Map extends AbstractMultiple
{
  /**
   * @var AbstractSingle[]|AbstractMultiple[]
   */
  protected $options = [];

  /**
   * @param array $options
   */
  public function __construct(array $options = [])
  {
    $this->options = $options;
  }

  /**
   * @param array $value
   * @return bool
   */
  public function isValid(?array $value): bool
  {
    $this->errors = [];

    foreach ($this->options as $key => $type) {
      if (!$type->isValid($value[$key] ?? null)) {
        $this->errors[$key] = $type->getErrors();
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

    foreach ($this->options as $key => $value) {
      $option = $this->options[$key];
      $data[$key] = $option->normalize($values[$key] ?? null);
    }

    return $data;
  }
}

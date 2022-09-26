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

    $keys = [
      ...array_keys($values),
      ...array_keys($this->options)
    ];

    foreach ($keys as $key) {

      if (isset($this->options[$key])) {
        $option = $this->options[$key];
        $normalizedValue = $option->normalize($values[$key] ?? null);
      }

      $data[$key] = $normalizedValue ?? $value[$key] ?? null;
    }

    return $data;
  }
}

<?php

namespace App\Traits;

trait PartiallyInitializedTrait
{
	private array $initializedProperties;

	public function addInitializedProperty(string $property): void
	{
		$this->initializedProperties[] = $property;
		$this->initializedProperties = array_unique($this->initializedProperties);
	}

	public function addInitializedProperties(array $properties): void
	{
		$this->initializedProperties = array_unique(array_merge($this->initializedProperties, $properties));
	}

	public function isPropertyInitialized(string $property): bool
	{
		return in_array($property, $this->initializedProperties);
	}

	public function arePropertiesInitialized(array $properties): bool
	{
		return count(array_diff($properties, $this->initializedProperties));
	}
}

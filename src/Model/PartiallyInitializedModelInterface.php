<?php

namespace App\Model;

interface PartiallyInitializedModelInterface
{
	public function addInitializedProperty(string $property): void;
	public function addInitializedProperties(array $properties): void;
	public function isPropertyInitialized(string $property): bool;
	public function arePropertiesInitialized(array $properties): bool;
}

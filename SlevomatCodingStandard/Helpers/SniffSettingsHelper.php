<?php declare(strict_types = 1);

namespace SlevomatCodingStandard\Helpers;

use function array_filter;
use function array_map;
use function array_values;
use function is_string;
use function preg_match;
use function trim;

class SniffSettingsHelper
{

	/**
	 * @param string|int $settings
	 * @return int
	 */
	public static function normalizeInteger($settings): int
	{
		return (int) trim((string) $settings);
	}

	/**
	 * @param mixed[] $settings
	 * @return mixed[]
	 */
	public static function normalizeArray(array $settings): array
	{
		$settings = array_map(function (string $value): string {
			return trim($value);
		}, $settings);
		$settings = array_filter($settings, function (string $value): bool {
			return $value !== '';
		});
		return array_values($settings);
	}

	/**
	 * @param mixed[] $settings
	 * @return mixed[]
	 */
	public static function normalizeAssociativeArray(array $settings): array
	{
		$normalizedSettings = [];
		foreach ($settings as $key => $value) {
			if (is_string($key)) {
				$key = trim($key);
			}
			if (is_string($value)) {
				$value = trim($value);
			}
			if ($key === '' || $value === '') {
				continue;
			}
			$normalizedSettings[$key] = $value;
		}

		return $normalizedSettings;
	}

	public static function isValidRegularExpression(string $expression): bool
	{
		return preg_match('~^(?:\(.*\)|\{.*\}|\[.*\])[a-z]*\z~i', $expression) !== 0
			|| preg_match('~^([^a-z\s\\\\]).*\\1[a-z]*\z~i', $expression) !== 0;
	}

}

<?php
/**
 * @var string $name
 * @var string|null $placeholder
 * @var string|null $value
 * @var int $maxLength
 * @var bool|null $isReadOnly
 * @var bool|null $isRequired
 * @var string $defaultValue
 */
?>
<input
	type="text"
	name="<?= $name ?>"
	<?= ! empty( $defaultValue ) ? "value=\"$defaultValue\"" : '' ?>
	<?= ! empty( $placeholder ) ? "placeholder=\"$placeholder\"" : '' ?>
	<?= ! empty( $value ) ? "value=\"$value\"" : '' ?>
	<?= ! empty( $maxLength ) ? "maxlength=\"$maxLength\"" : '' ?>
	<?= ! empty( $isRequired ) ? 'required' : '' ?>
	<?= ! empty( $isReadOnly ) ? 'readonly' : '' ?>
>

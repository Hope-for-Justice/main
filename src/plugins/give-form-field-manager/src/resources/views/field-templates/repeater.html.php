<?php

use GiveFormFieldManager\Infrastructure\View;

/**
 * @var GiveFormFieldManager\FormFields\Fields\Repeater $field
 * @var int $fieldId
 * @var string $fieldIdAttribute
 */

$columns    = $field->getColumns();
$hasColumns = ! empty( $columns );
// So we don’t keep calling these in loops
$name         = $field->getName();
$isRequired   = $field->isRequired();
$isReadOnly   = $field->isReadOnly();
$maxLength    = $field->getMaxLength();
$defaultValue = $field->getDefaultValue();
?>
<table
	class="give-repeater-table"
	data-field-type="repeater"
	data-max-repeat="<?= $field->getMaxRepeatable() ?>"
>
	<?php if ( $hasColumns ) : ?>
		<thead>
		<?php foreach ( $columns as $column ) : ?>
			<th><?= $column ?></th>
		<?php endforeach; ?>
		<th class="screen-reader-text">
			<?= __( 'Actions', 'give-form-field-manager' ) ?>
		</th>
		</thead>
		<tbody>
			<tr>
				<?php foreach ( $columns as $index => $column ) : ?>
					<td>
						<?php
							View::render(
								'field-templates/repeater-input.html',
								[
									'name'         => "{$name}[{$index}][]",
									'maxLength'    => $maxLength,
									'isRequired'   => $isRequired,
									'isReadOnly'   => $isReadOnly,
									'defaultValue' => $defaultValue,
								]
							);
						?>
					</td>
				<?php endforeach; ?>
				<td>
					<?php View::render( 'field-templates/repeater-buttons.html' ); ?>
				</td>
			</tr>
		</tbody>
	<?php else : ?>
		<tr>
			<td>
				<?php
					View::render(
						'field-templates/repeater-input.html',
						[
							'name' => "{$name}[]",
							'placeholder' => $field->getPlaceholder(),
							'value' => $maxLength ?
								substr( $field->getDefaultValue(), 0, $maxLength ) :
								$field->getDefaultValue(),
							'maxLength' => $maxLength,
							'isRequired' => $isRequired,
							'isReadOnly' => $isReadOnly,
						]
					);
				?>
			</td>
			<td>
				<?php View::render( 'field-templates/repeater-buttons.html' ); ?>
			</td>
		</tr>
	<?php endif; ?>
</table>

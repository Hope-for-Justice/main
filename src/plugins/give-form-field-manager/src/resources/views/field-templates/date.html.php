<?php /** @var \GiveFormFieldManager\FormFields\Fields\Date $field */ ?>
<?php /** @var string $typeAttribute */ ?>
<?php /** @var string $fieldIdAttribute */ ?>
<input
	type="text"
	name="<?php echo $field->getName(); ?>"
	id="<?php echo $fieldIdAttribute; ?>"
	value="<?php echo $field->getDefaultValue(); ?>"
	data-timeformat="<?php echo $field->getTimeFormat(); ?>"
	data-dateformat="<?php echo $field->getDateFormat(); ?>"
	autocomplete="off"
	class="give-ffm-date <?php echo $field->getTimeFormat() ? 'give-ffm-timepicker' : ''; ?>"
	<?php echo $field->isRequired() ? 'required' : ''; ?>
	<?php echo $field->isReadOnly() ? 'readonly' : ''; ?>
>

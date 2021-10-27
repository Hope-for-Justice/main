<?php
/** @var WPEditor $field */

use GiveFormFieldManager\FormFields\Fields\WPEditor;

wp_editor(
	$field->getDefaultValue(),
	$field->getName(),
	$field->getEditorConfig()
);

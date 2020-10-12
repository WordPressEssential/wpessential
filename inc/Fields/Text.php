<?php

namespace WPEssential\Plugins\Fields;

use WPEssential\Plugins\Implement\Fields;

class Text extends Field implements Fields
{
	/**
	 * The type of the control.
	 *
	 * @var string
	 */
	public string $type = 'text';

	/**
	 * The field's input type. The input field type. Available values are all HTML5 supported types.
	 *
	 * @var string
	 */
	public string $inputType = 'text';

	/**
	 * Set the callback to be used for determining the field's input type value.
	 *
	 * @param $callback
	 * @return $this
	 */
	public function inputType ( $callback )
	{
		$this->inputType = $callback;

		return $this;
	}

	/**
	 * Prepare the field's.
	 *
	 * @return array
	 */
	public function prepear ()
	{
		return [
			'input_type' => $this->inputType,
		];
	}

	/**
	 * Prepare the field's json serialize.
	 *
	 * @return array
	 */
	public function jsonSerialize ()
	{
		return wp_parse_args( $this->prepear(), parent::jsonSerialize() );
	}

	/**
	 * Prepare the field's array.
	 *
	 * @return array
	 */
	public function toArray ()
	{
		return wp_parse_args( $this->prepear(), parent::toArray() );
	}

}

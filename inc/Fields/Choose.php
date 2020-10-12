<?php

namespace WPEssential\Plugins\Fields;

use WPEssential\Plugins\Implement\Fields;

class Choose extends Field implements Fields
{
	/**
	 * The type of the control.
	 *
	 * @var string
	 */
	public string $type = 'choose';

	/**
	 * An array of key => value pairs: [ 'key' => 'value', ... ]
	 *
	 * @var array
	 */
	public array $options;

	/**
	 * Whether to allow toggle / unset the selection.
	 *
	 * @var bool
	 */
	public bool $toggle = true;

	/**
	 * Set the callback to be used for determining the field's array of key => value pairs: [ 'key' => 'value', ... ].
	 *
	 * @param $callback
	 * @return $this
	 */
	public function options ( $callback )
	{
		$this->options = $callback;

		return $this;
	}

	/**
	 * Set the callback to be used for determining the field's allow toggle / unset the selection.
	 *
	 * @param $callback
	 * @return $this
	 */
	public function toggle ( $callback )
	{
		$this->toggle = $callback;

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
			'options' => $this->options,
			'toggle'  => $this->toggle,
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
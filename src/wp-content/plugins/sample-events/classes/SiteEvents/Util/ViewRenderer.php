<?php

// Set class namespace. ViewRenderer is used on plugin level instead of theme so the plugins can function as themselves.
namespace SiteEvents\Util;

class ViewRenderer {

	/**
	* Path to the template which shall be rendered
	* @var       string
	*/
	protected $template;

	/**
	* Standard Class
	* @var       stdClass
	*/
	protected $data;

	public function __construct ( $template, array $data ) {
		$this->template = $template;
		$this->data = (object) $data; // Change array to standard class
	}

	/** Renders the template */
	public function render () {
		// Pass to $data variable for ease of use on templates
		$data = $this->data;

		if (!file_exists($this->template))
			return;

		include $this->template;
	}
}
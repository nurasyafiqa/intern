<?php

namespace Tools\View\Helper;

use Cake\Core\Configure;
use Cake\Utility\Hash;
use Cake\View\Helper\FormHelper as CakeFormHelper;
use Cake\View\View;

/**
 * Overwrite
 *
 * @property \Cake\View\Helper\UrlHelper $Url
 * @property \Cake\View\Helper\HtmlHelper $Html
 */
class FormHelper extends CakeFormHelper {

	/**
	 * @var array<string, mixed>
	 */
	protected array $_defaultConfigExt = [
		'novalidate' => false,
	];

	/**
	 * Construct the widgets and binds the default context providers
	 *
	 * @param \Cake\View\View $View The View this helper is being attached to.
	 * @param array<string, mixed> $config Configuration settings for the helper.
	 */
	public function __construct(View $View, array $config = []) {
		$this->_defaultConfig += $this->_defaultConfigExt;
		$defaultConfig = (array)Configure::read('FormConfig');
		if ($defaultConfig) {
			$this->_defaultConfig = Hash::merge($this->_defaultConfig, $defaultConfig);
		}
		parent::__construct($View, $config);
	}

	/**
	 * Overwrite to allow FormConfig Configure settings to be applied.
	 *
	 * @param mixed $context The context for which the form is being defined. Can
	 *   be an ORM entity, ORM resultset, or an array of meta data. You can use false or null
	 *   to make a model-less form.
	 * @param array<string, mixed> $options An array of html attributes and options.
	 * @return string An formatted opening FORM tag.
	 */
	public function create(mixed $context = null, array $options = []): string {
		$defaults = ['novalidate' => $this->_defaultConfig['novalidate']];
		$options += $defaults;

		return parent::create($context, $options);
	}

}

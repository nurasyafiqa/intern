<?php

namespace Tools\View\Helper;

use Cake\Core\Configure;
use Cake\View\Helper;
use Cake\View\StringTemplate;
use Cake\View\View;
use RuntimeException;
use Shim\Utility\Inflector as ShimInflector;
use Templating\View\Helper\IconHelper;

/**
 * Format helper with basic HTML snippets
 *
 * @author Mark Scherer
 * @license MIT
 * @property \Cake\View\Helper\HtmlHelper $Html
 * @property \Tools\View\Helper\IconHelper $Icon
 */
class FormatHelper extends Helper {

	/**
	 * Other helpers used by FormHelper
	 *
	 * @var array
	 */
	protected array $helpers = ['Html'];

	/**
	 * @var \Cake\View\StringTemplate
	 */
	protected $template;

	/**
	 * @var array
	 */
	protected array $_defaults = [
		'templates' => [
			'icon' => '<i class="{{class}}"{{attributes}}></i>',
			'ok' => '<span class="ok-{{type}}" style="color:{{color}}"{{attributes}}>{{content}}</span>',
		],
		'slugger' => null,
	];

	/**
	 * @param \Cake\View\View $View
	 * @param array<string, mixed> $config
	 */
	public function __construct(View $View, array $config = []) {
		if (class_exists(IconHelper::class)) {
			$this->helpers[] = 'Templating.Icon';
		} else {
			$this->helpers[] = 'Tools.Icon';
		}

		$defaults = (array)Configure::read('Format') + $this->_defaults;
		$config += $defaults;

		$this->template = new StringTemplate($config['templates']);

		parent::__construct($View, $config);
	}

	/**
	 * Make sure to configure these (font) icons in your `Icon.map` app config, e.g.
	 *   'pro' => 'fa4:thumbs-up',
	 *   'contra' => 'fa4:thumbs-down',
	 *
	 * @deprecated Use Templating.IconSnippet helper instead.
	 *
	 * @param mixed $value Boolish value
	 * @param array<string, mixed> $options
	 * @param array<string, mixed> $attributes
	 *
	 * @return string
	 */
	public function thumbs($value, array $options = [], array $attributes = []): string {
		$icon = !empty($value) ? 'pro' : 'contra';

		return $this->Icon->render($icon, $options, $attributes);
	}

	/**
	 * Display neighbor quicklinks
	 *
	 * Make sure to configure these (font) icons in your `Icon.map` app config, e.g.
	 *   'prev' => 'fa4:arrow-left',
	 *   'next' => 'fa4:arrow-right',
	 *
	 * @deprecated Use Templating.IconSnippet helper instead.
	 *
	 * @param array $neighbors (containing prev and next)
	 * @param string $field Field as `Field` or `Model.field` syntax
	 * @param array<string, mixed> $options :
	 * - name: title name: next{Record} (if none is provided, "record" is used - not translated!)
	 * - slug: true/false (defaults to false)
	 * - titleField: field or `Model.field`
	 *
	 * @return string
	 */
	public function neighbors(array $neighbors, string $field, array $options = []): string {
		$name = 'Record'; // Translation further down!
		if (!empty($options['name'])) {
			$name = ucfirst($options['name']);
		}

		$prevSlug = $nextSlug = null;
		if (!empty($options['slug'])) {
			if (!empty($neighbors['prev'])) {
				$prevSlug = $this->slug($neighbors['prev'][$field]);
			}
			if (!empty($neighbors['next'])) {
				$nextSlug = $this->slug($neighbors['next'][$field]);
			}
		}
		$titleField = $field;
		if (!empty($options['titleField'])) {
			$titleField = $options['titleField'];
		}
		if (!isset($options['escape']) || $options['escape'] === false) {
			$titleField = h($titleField);
		}

		$ret = '<div class="next-prev-navi nextPrevNavi">';
		if (!empty($neighbors['prev'])) {
			$url = [$neighbors['prev']['id'], $prevSlug];
			if (!empty($options['url'])) {
				$url += $options['url'];
			}

			$ret .= $this->Html->link(
				(string)$this->Icon->render('prev') . '&nbsp;' . __d('tools', 'prev' . $name),
				$url,
				['escape' => false, 'title' => $neighbors['prev'][$titleField]],
			);
		} else {
			$ret .= $this->Icon->render('prev');
		}

		$ret .= '&nbsp;&nbsp;';
		if (!empty($neighbors['next'])) {
			$url = [$neighbors['next']['id'], $nextSlug];
			if (!empty($options['url'])) {
				$url += $options['url'];
			}

			$ret .= $this->Html->link(
				(string)$this->Icon->render('next') . '&nbsp;' . __d('tools', 'next' . $name),
				$url,
				['escape' => false, 'title' => $neighbors['next'][$titleField]],
			);
		} else {
			$ret .= $this->Icon->render('next') . '&nbsp;' . __d('tools', 'next' . $name);
		}

		$ret .= '</div>';

		return $ret;
	}

	/**
	 * @var int
	 */
	public const GENDER_FEMALE = 2;

	/**
	 * @var int
	 */
	public const GENDER_MALE = 1;

	/**
	 * Displays gender icon
	 *
	 * Make sure to configure these (font) icons in your `Icon.map` app config, if
	 * you want to have different ones than the default icons.
	 *
	 * @param string|int $value
	 * @param array<string, mixed> $options
	 * @param array<string, mixed> $attributes
	 *
	 * @return string
	 */
	public function genderIcon($value, array $options = [], array $attributes = []): string {
		$value = (int)$value;
		if ($value == static::GENDER_FEMALE) {
			$icon = $this->Icon->render('female', $options, $attributes);
		} elseif ($value == static::GENDER_MALE) {
			$icon = $this->Icon->render('male', $options, $attributes);
		} else {
			$icon = $this->Icon->render('genderless', $options, $attributes + ['title' => __d('tools', 'Inter')]);
		}

		return $icon;
	}

	/**
	 * Displays yes/no symbol.
	 *
	 * Make sure to configure these (font) icons in your `Icon.map` app config, e.g.
	 *   'yes' => 'fa4:check',
	 *   'no' => 'fa4:times',
	 *
	 * @deprecated Use Templating.IconSnippet helper instead.
	 *
	 * @param int|bool $value Value
	 * @param array<string, mixed> $options
	 * - on (defaults to 1/true)
	 * - onTitle
	 * - offTitle
	 * @param array<string, mixed> $attributes
	 * - title, ...
	 *
	 * @return string HTML icon Yes/No
	 */
	public function yesNo($value, array $options = [], array $attributes = []): string {
		$defaults = [
			'on' => 1,
			'onTitle' => __d('tools', 'Yes'),
			'offTitle' => __d('tools', 'No'),
		];
		$options += $defaults;

		if ($value == $options['on']) {
			$icon = 'yes';
			$value = 'on';
		} else {
			$icon = 'no';
			$value = 'off';
		}

		$attributes += ['title' => $options[$value . 'Title']];

		return $this->Icon->render($icon, $options, $attributes);
	}

	/**
	 * Img Icons
	 *
	 * @param string $icon (constant or filename)
	 * @param array<string, mixed> $options :
	 * - translate, title, ...
	 * @param array<string, mixed> $attributes :
	 * - class, ...
	 * @return string
	 */
	public function cIcon($icon, array $options = [], array $attributes = []): string {
		$translate = $options['translate'] ?? true;

		$type = pathinfo($icon, PATHINFO_FILENAME);
		$title = ucfirst($type);
		$alt = $this->slug($title);
		if ($translate !== false) {
			$title = __($title);
			$alt = __($alt);
		}
		$alt = '[' . $alt . ']';

		$defaults = ['title' => $title, 'alt' => $alt, 'class' => 'icon'];

		$options = $attributes + $options;
		$options += $defaults;
		if (substr($icon, 0, 1) !== '/') {
			$icon = 'icons/' . $icon;
		}

		return $this->Html->image($icon, $options);
	}

	/**
	 * Gets URL of a png img of a website (16x16 pixel).
	 *
	 * @param string $domain
	 * @return string
	 */
	public function siteIconUrl($domain) {
		if (str_starts_with($domain, 'http')) {
			// Strip protocol
			$pieces = parse_url($domain);
			if ($pieces !== false) {
				$domain = $pieces['host'];
			}
		}

		return 'http://www.google.com/s2/favicons?domain=' . $domain;
	}

	/**
	 * Display a png img of a website (16x16 pixel)
	 * if not available, will return a fallback image (a globe)
	 *
	 * @param string $domain (preferably without protocol, e.g. "www.site.com")
	 * @param array<string, mixed> $options
	 * @return string
	 */
	public function siteIcon($domain, array $options = []) {
		$url = $this->siteIconUrl($domain);
		$options['width'] = 16;
		$options['height'] = 16;
		if (!isset($options['alt'])) {
			$options['alt'] = $domain;
		}
		if (!isset($options['title'])) {
			$options['title'] = $domain;
		}

		return $this->Html->image($url, $options);
	}

	/**
	 * Display a disabled link tag
	 *
	 * @param string $text
	 * @param array<string, mixed> $options
	 * @return string
	 */
	public function disabledLink($text, array $options = []) {
		$defaults = ['class' => 'disabledLink', 'title' => __d('tools', 'notAvailable')];
		$options += $defaults;

		return $this->Html->tag('span', $text, $options);
	}

	/**
	 * Fixes utf8 problems of native php str_pad function
	 * //TODO: move to textext helper? Also note there is Text::wrap() now.
	 *
	 * @param string $input
	 * @param int $padLength
	 * @param string $padString
	 * @param mixed $padType
	 * @return string input
	 */
	public function pad($input, $padLength, $padString, $padType = STR_PAD_RIGHT) {
		$length = mb_strlen($input);
		if ($padLength - $length > 0) {
			switch ($padType) {
				case STR_PAD_LEFT:
					$input = str_repeat($padString, $padLength - $length) . $input;

					break;
				case STR_PAD_RIGHT:
					$input .= str_repeat($padString, $padLength - $length);

					break;
			}
		}

		return $input;
	}

	/**
	 * Returns red colored if not ok.
	 *
	 * WARNING: This method requires manual escaping of input - h() must be used
	 * for non HTML content.
	 *
	 * @deprecated Use Templating.Templating helper instead.
	 *
	 * @param string $value
	 * @param mixed $ok Boolish value
	 * @return string Value in HTML tags
	 */
	public function warning($value, $ok = false) {
		if (!$ok) {
			return $this->ok($value, false);
		}

		return $value;
	}

	/**
	 * Returns green on ok, red otherwise.
	 *
	 * WARNING: This method requires manual escaping of input - h() must be used
	 *  for non HTML content.
	 *
	 * @deprecated Use Templating.Templating helper instead.
	 *
	 * @param mixed $content Output
	 * @param bool $ok Boolish value
	 * @param array<string, mixed> $attributes
	 * @return string Value nicely formatted/colored
	 */
	public function ok($content, $ok = false, array $attributes = []) {
		if ($ok) {
			$type = 'yes';
			$color = 'green';
		} else {
			$type = 'no';
			$color = 'red';
		}

		$options = [
			'type' => $type,
			'color' => $color,
		];
		$options['content'] = $content;
		$options['attributes'] = $this->template->formatAttributes($attributes);

		return $this->template->format('ok', $options);
	}

	/**
	 * Prepared string for output inside `<pre>...</pre>`.
	 *
	 * @param string $text
	 * @param array $options
	 *
	 * @return string
	 */
	public function pre(string $text, array $options = []): string {
		$options += [
			'escape' => true,
			'space' => 4,
		];

		if ($options['escape']) {
			$text = h($text);
		}

		$text = str_replace("\t", str_repeat(' ', $options['space']), $text);

		return $text;
	}

	/**
	 * Useful for displaying tabbed (code) content when the default of 8 spaces
	 * inside <pre> is too much. This converts it to spaces for better output.
	 *
	 * Inspired by the tab2space function found at:
	 *
	 * @see http://aidan.dotgeek.org/lib/?file=function.tab2space.php
	 * @param string $text
	 * @param int $spaces
	 * @return string
	 */
	public function tab2space($text, $spaces = 4) {
		$spacesString = str_repeat(' ', $spaces);
		$splitText = preg_split("/\r\n|\r|\n/", trim($text));
		if ($splitText === false) {
			return $text;
		}

		$wordLengths = [];
		$wArray = [];

		// Store word lengths
		foreach ($splitText as $line) {
			$words = preg_split("/(\t+)/", $line, -1, PREG_SPLIT_DELIM_CAPTURE);
			foreach (array_keys($words) as $i) {
				$strlen = strlen($words[$i]);
				$add = isset($wordLengths[$i]) && ($wordLengths[$i] < $strlen);
				if ($add || !isset($wordLengths[$i])) {
					$wordLengths[$i] = $strlen;
				}
			}
			$wArray[] = $words;
		}

		$text = '';

		// Apply padding when appropriate and rebuild the string
		foreach (array_keys($wArray) as $i) {
			foreach (array_keys($wArray[$i]) as $ii) {
				if (preg_match("/^\t+$/", $wArray[$i][$ii])) {
					$wArray[$i][$ii] = str_pad($wArray[$i][$ii], $wordLengths[$ii], "\t");
				} else {
					$wArray[$i][$ii] = str_pad($wArray[$i][$ii], $wordLengths[$ii]);
				}
			}
			$text .= str_replace("\t", $spacesString, implode('', $wArray[$i])) . "\n";
		}

		return $text;
	}

	/**
	 * Translate a result array into a HTML table
	 *
	 * @todo Move to Text Helper etc.
	 *
	 * Options:
	 * - recursive: Recursively generate tables for multi-dimensional arrays
	 * - heading: Display the first as heading row (th)
	 * - escape: Defaults to true
	 * - null: Null value
	 *
	 * @author Aidan Lister <aidan@php.net>
	 * @version 1.3.2
	 * @link http://aidanlister.com/2004/04/converting-arrays-to-human-readable-tables/
	 * @param array $array The result (numericaly keyed, associative inner) array.
	 * @param array<string, mixed> $options
	 * @param array<string, mixed> $attributes For the table
	 * @return string
	 */
	public function array2table(array $array, array $options = [], array $attributes = []) {
		$defaults = [
			'null' => '&nbsp;',
			'recursive' => false,
			'heading' => true,
			'escape' => true,
		];
		$options += $defaults;

		// Sanity check
		if (!$array) {
			return '';
		}

		if (!isset($array[0]) || !is_array($array[0])) {
			$array = [$array];
		}

		$attributes += [
			'class' => 'table',
		];

		$attributes = $this->template->formatAttributes($attributes);

		// Start the table
		$table = "<table$attributes>\n";

		if ($options['heading']) {
			// The header
			$table .= "\t<tr>";
			// Take the keys from the first row as the headings
			foreach (array_keys($array[0]) as $heading) {
				$table .= '<th>' . ($options['escape'] ? h($heading) : $heading) . '</th>';
			}
			$table .= "</tr>\n";
		}

		// The body
		foreach ($array as $row) {
			$table .= "\t<tr>";
			foreach ($row as $cell) {
				$table .= '<td>';

				// Cast objects
				if (is_object($cell)) {
					$cell = (array)$cell;
				}

				if ($options['recursive'] && is_array($cell) && !empty($cell)) {
					// Recursive mode
					$table .= "\n" . static::array2table($cell, $options) . "\n";
				} else {
					$table .= (!is_array($cell) && strlen($cell) > 0) ? ($options['escape'] ? h(
						$cell,
					) : $cell) : $options['null'];
				}

				$table .= '</td>';
			}

			$table .= "</tr>\n";
		}

		$table .= '</table>';

		return $table;
	}

	/**
	 * @param string $string
	 *
	 * @throws \RuntimeException
	 * @return string
	 */
	public function slug($string) {
		if ($this->_config['slugger']) {
			$callable = $this->_config['slugger'];
			if (!is_callable($callable)) {
				throw new RuntimeException('Invalid callable passed as slugger.');
			}

			return $callable($string);
		}

		return ShimInflector::slug($string);
	}

}

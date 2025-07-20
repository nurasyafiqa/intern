<?php

namespace Tools\Test\TestCase\View\Helper;

use Cake\Core\Configure;
use Cake\View\View;
use Shim\TestSuite\TestCase;
use Tools\Utility\Text;
use Tools\View\Helper\FormatHelper;
use Tools\View\Icon\BootstrapIcon;

class FormatHelperTest extends TestCase {

	/**
	 * @var array<string>
	 */
	protected array $fixtures = [
		'plugin.Tools.Sessions',
	];

	/**
	 * @var \Tools\View\Helper\FormatHelper
	 */
	protected FormatHelper $Format;

	/**
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$this->loadRoutes();

		Configure::write('App.imageBaseUrl', 'img/');
		Configure::write('Icon', [
			'sets' => [
				'bs' => BootstrapIcon::class,
			],
		]);

		$this->Format = new FormatHelper(new View(null));
	}

	/**
	 * @return void
	 */
	public function testDisabledLink() {
		$content = 'xyz';
		$data = [
			[],
			['class' => 'disabledLink', 'title' => false],
			['class' => 'helloClass', 'title' => 'helloTitle'],
		];
		foreach ($data as $key => $value) {
			$res = $this->Format->disabledLink($content, $value);
			//echo ''.$res.' (\''.h($res).'\')';
			$this->assertTrue(!empty($res));
		}
	}

	/**
	 * @return void
	 */
	public function testWarning() {
		$content = 'xyz';
		$data = [
			true,
			false,
		];
		foreach ($data as $key => $value) {
			$res = $this->Format->warning($content . ' ' . (int)$value, $value);
			//echo ''.$res.'';
			$this->assertTrue(!empty($res));
		}
	}

	/**
	 * @return void
	 */
	public function testYesNo() {
		$result = $this->Format->yesNo(true);
		$expected = '<span class="bi bi-yes" title="Yes"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->yesNo(false);
		$expected = '<span class="bi bi-no" title="No"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->yesNo('2', ['on' => 2, 'onTitle' => 'foo']);
		$expected = '<span class="bi bi-yes" title="foo"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->yesNo('3', ['on' => 4, 'offTitle' => 'nope']);
		$expected = '<span class="bi bi-no" title="nope"></span>';
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testOk() {
		$content = 'xyz';
		$data = [
			true => '<span class="ok-yes" style="color:green">xyz 1</span>',
			false => '<span class="ok-no" style="color:red">xyz 0</span>',
		];
		foreach ($data as $value => $expected) {
			$result = $this->Format->ok($content . ' ' . (int)$value, $value);
			$this->assertEquals($expected, $result);
		}
	}

	/**
	 * FormatHelperTest::testThumbs()
	 *
	 * @return void
	 */
	public function testThumbs() {
		$result = $this->Format->thumbs(1);
		$expected = '<span class="bi bi-pro" title="Pro"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->thumbs(0);
		$expected = '<span class="bi bi-contra" title="Contra"></span>';
		$this->assertEquals($expected, $result);
	}

	/**
	 * FormatHelperTest::testGenderIcon()
	 *
	 * @return void
	 */
	public function testGenderIcon() {
		$result = $this->Format->genderIcon(0);

		$expected = '<span class="bi bi-genderless" title="Inter"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->genderIcon(1);

		$expected = '<span class="bi bi-male" title="Male"></span>';
		$this->assertEquals($expected, $result);

		$result = $this->Format->genderIcon(2);

		$expected = '<span class="bi bi-female" title="Female"></span>';
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testPad() {
		$result = $this->Format->pad('foo bär', 20, '-');
		$expected = 'foo bär-------------';
		$this->assertEquals($expected, $result);

		$result = $this->Format->pad('foo bär', 20, '-', STR_PAD_LEFT);
		$expected = '-------------foo bär';
		$this->assertEquals($expected, $result);
	}

	/**
	 * FormatHelperTest::testSiteIcon()
	 *
	 * @return void
	 */
	public function testSiteIcon() {
		$result = $this->Format->siteIcon('http://www.example.org');
		$this->debug($result);
		$expected = '<img src="http://www.google.com/s2/favicons?domain=www.example.org';
		$this->assertStringContainsString($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testSlug() {
		$result = $this->Format->slug('A Baz D & Foo');
		$this->assertSame('A-Baz-D-Foo', $result);

		$this->Format->setConfig('slugger', [Text::class, 'slug']);
		$result = $this->Format->slug('A Baz D & Foo');
		$this->assertSame('A-Baz-D-Foo', $result);
	}

	/**
	 * @return void
	 */
	public function testSlugCustomObject() {
		$this->Format->setConfig('slugger', [$this, '_testSlugger']);
		$result = $this->Format->slug('A Baz D & Foo');
		$this->assertSame('a baz d & foo', $result);
	}

	/**
	 * @param string $name
	 *
	 * @return string
	 */
	public function _testSlugger($name) {
		return mb_strtolower($name);
	}

	/**
	 * @return void
	 */
	public function testNeighbors() {
		$this->skipIf(true, '//TODO');

		$neighbors = [
			'prev' => ['id' => 1, 'foo' => 'bar'],
			'next' => ['id' => 2, 'foo' => 'y'],
		];

		$result = $this->Format->neighbors($neighbors, 'foo');
		$expected = '<div class="next-prev-navi"><a href="/index/1" title="bar"><i class="icon icon-prev fa fa-arrow-left" title="" data-placement="bottom" data-toggle="tooltip"></i>&nbsp;prevRecord</a>&nbsp;&nbsp;<a href="/index/2" title="y"><i class="icon icon-next fa fa-arrow-right" title="" data-placement="bottom" data-toggle="tooltip"></i>&nbsp;nextRecord</a></div>';
		$this->assertEquals($expected, $result);
	}

	/**
	 * Test slug generation works with new slugger.
	 *
	 * @return void
	 */
	public function testSlugGenerationWithNewSlugger() {
		$neighbors = [
			'prev' => ['id' => 1, 'foo' => 'My Foo'],
			'next' => ['id' => 2, 'foo' => 'My FooBaz'],
		];

		// Only needed for fake requests (tests)
		$url = ['controller' => 'MyController', 'action' => 'myAction'];
		$result = $this->Format->neighbors($neighbors, 'foo', ['slug' => true, 'url' => $url]);

		$expected = '<div class="next-prev-navi nextPrevNavi"><a href="/my-controller/my-action/1/My-Foo" title="My Foo"><span class="bi bi-prev" title="Prev"></span>&nbsp;prevRecord</a>&nbsp;&nbsp;<a href="/my-controller/my-action/2/My-FooBaz" title="My FooBaz"><span class="bi bi-next" title="Next"></span>&nbsp;nextRecord</a></div>';
		$this->assertEquals($expected, $result);
	}

	/**
	 * @return void
	 */
	public function testTab2space() {
		$text = "foo\t\tfoobar\tbla\n";
		$text .= "fooo\t\tbar\t\tbla\n";
		$text .= "foooo\t\tbar\t\tbla\n";
		$result = $this->Format->tab2space($text);

		$expected = <<<TXT
foo          foobar        bla
fooo         bar           bla
foooo        bar           bla

TXT;
		$this->assertTextEquals($expected, $result);
		$this->assertTrue(strpos($result, "\t") === false);
	}

	/**
	 * @return void
	 */
	public function testArray2table() {
		$array = [
			['x' => '0', 'y' => '0.5', 'z' => '0.9'],
			['1', '2', '3'],
			['4', '5', '6'],
		];

		$is = $this->Format->array2table($array);
		$this->assertTextContains('<table class="table">', $is);
		$this->assertTextContains('</table>', $is);
		$this->assertTextContains('<th>', $is);

		// recursive
		$array = [
			['a' => ['2'], 'b' => ['2'], 'c' => ['2']],
			[['2'], ['2'], ['2']],
			[['2'], ['2'], [['s' => '3', 't' => '4']]],
		];

		$is = $this->Format->array2table($array, ['recursive' => true]);
		$expected = <<<TEXT
<table class="table">
	<tr><th>a</th><th>b</th><th>c</th></tr>
	<tr><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td></tr>
	<tr><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td></tr>
	<tr><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>0</th></tr>
	<tr><td>2</td></tr>
</table>
</td><td>
<table class="table">
	<tr><th>s</th><th>t</th></tr>
	<tr><td>3</td><td>4</td></tr>
</table>
</td></tr>
</table>
TEXT;
		$this->assertTextEquals($expected, $is);

		$array = [
			['x' => '0', 'y' => '0.5', 'z' => '0.9'],
			['1', '2', '3'],
		];

		$options = [
			'heading' => false,
		];
		$attributes = [
			'class' => 'foo',
			'data-x' => 'y',
		];

		$is = $this->Format->array2table($array, $options, $attributes);
		$this->assertTextContains('<table class="foo" data-x="y">', $is);
		$this->assertTextContains('</table>', $is);
		$this->assertTextNotContains('<th>', $is);
	}

	/**
	 * @return void
	 */
	public function tearDown(): void {
		parent::tearDown();

		unset($this->Format);

		Configure::delete('App.imageBaseUrl');
		Configure::delete('Icon');
	}

}

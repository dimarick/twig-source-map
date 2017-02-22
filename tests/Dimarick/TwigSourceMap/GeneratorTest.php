<?php

namespace Dimarick\TwigSourceMap;

use PHPUnit\Framework\TestCase;

class GeneratorTest extends TestCase
{
	public function testGenerate()
	{
		$template = $this->getMockForAbstractClass(\Twig_Template::class,
			[],
			'',
			false,
			false,
			true,
			['getDebugInfo', 'getSourceContext']
		);

		$template->method('getDebugInfo')->willReturn([
			1 => 2,
			2 => 5,
			3 => 8
		]);

		$template->method('getSourceContext')->willReturn(new \Twig_Source('', 'test.twig', '/path/to/test.twig'));

		$generator = new Generator();
		$map = $generator->generate($template);
		$this->assertInstanceOf(MapFile::class, $map);
		$this->assertStringEndsWith('.map', $map->getPath());
		$this->assertEquals('{"version":3,"mappings":"AACA;AAGA;AAGA","sources":["\/path\/to\/test.twig"],"names":[],"_x_org_koala-framework_last":{"source":0,"originalLine":7,"originalColumn":0,"name":0}}', $map->getSource());
	}

	public function testGenerateForFiles()
	{
		$cachePath = __DIR__ . '/../../../var';
		`rm -r $cachePath/*`;

		$twig = new \Twig_Environment(new \Twig_Loader_Filesystem([
			__DIR__ . '/../../Fixtures/'
		]), [
			'cache' => $cachePath
		]);

		$generator = new Generator();

		$template = $twig->load('test.html.twig');
		$tpl = $twig->resolveTemplate($template->getSourceContext()->getName());

		$map = $generator->generate($tpl);
		file_put_contents($map->getPath(), $map->getSource());
		$this->assertInstanceOf(MapFile::class, $map);
		$this->assertStringEndsWith('.map', $map->getPath());
		$this->assertNotEmpty($map->getSource());

		$template = $twig->load('test2.html.twig');
		$tpl = $twig->resolveTemplate($template->getSourceContext()->getName());

		$map = $generator->generate($tpl);
		file_put_contents($map->getPath(), $map->getSource());
		$this->assertInstanceOf(MapFile::class, $map);
		$this->assertStringEndsWith('.map', $map->getPath());
		$this->assertNotEmpty($map->getSource());
	}
}

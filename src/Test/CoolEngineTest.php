<?php

use CoolView\CoolEngine;
use PHPUnit\Framework\TestCase;

class CoolEngineTest extends TestCase {

    private CoolEngine $coolEngine;

    public function setUp() : void {

        $this->coolEngine = new CoolEngine(
            getcwd() . '/template/views',
            getcwd() . '/template/caches'
        );

    }

    public function testRenderThrowsExceptionIfViewNotFound() : void{

        $this->expectException(\RuntimeException::class);

        $this->expectExceptionMessage("View file 'nonexistent' not found.");

        $this->coolEngine->render('nonexistent');

    }

    public function testRenderViewExists(): void {

        $output = $this->coolEngine->render('test', ['name' => 'Arash']);

        $this->assertStringContainsString('Hello Arash', $output);

    }

    public function testRenderViewDoesNotExist(): void {

        $this->expectException(RuntimeException::class);

        $this->coolEngine->render('nonexistent');

    }

    public function testCompileTemplate() : void {
        $compiledPath = getcwd() . '/template/caches/' . md5('test') . '.cool.php';

        $this->coolEngine->render('test', ['name' => 'Arash']);

        $this->assertFileExists($compiledPath);
    }

    public function testClearCache(): void {

        $this->coolEngine->clearCache();

        $cachedFiles = glob(getcwd() . '/template/caches/*.php');

        $this->assertEmpty($cachedFiles);
    }

    public function testDirectives(): void {

        $viewFile = getcwd() . '/template/views/temp_test.cool.php';

        file_put_contents($viewFile, '{{ $name | upper }}');

        $compiledContent = $this->coolEngine->render('temp_test', ['name' => 'arash']);

        $this->assertEquals('ARASH', $compiledContent);

        unlink($viewFile);

    }

    public function testSectionManagement(): void {

        $this->coolEngine->startSection('header');

        echo 'Header Content';

        $this->coolEngine->endSection();

        $output = $this->coolEngine->yieldSection('header');

        $this->assertEquals('Header Content', $output);
    }
}
<?php

namespace Tests\Unit\Core;

use Faker\Factory;
use Tests\TestCase;
use App\Contracts\Core\Converter;
use App\Facades\Core\Converter as ConverterFacade;
use Symfony\Component\HttpFoundation\File\Exception\ExtensionFileException;

class ConverterTest extends TestCase {

    /**
     * @var Converter
     */
    private $converter;

    public function setUp(): void {
        parent::setUp();

        $this->converter = resolve(Converter::class);
    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testConvertImageByUrl() {
        $faker = Factory::create();
        $imageUrl = $faker->imageUrl();
        $strFilePath = $this->converter->convertImageToPng("https://loremflickr.com/640/360");

        $this->assertIsString($strFilePath);
        $this->assertFileExists($strFilePath);

        $this->assertEquals(IMAGETYPE_PNG, exif_imagetype($strFilePath));

        unlink($strFilePath);
    }

    public function testConvertImageByPath() {
        $imagePath = "https://loremflickr.com/640/360";
        $strFilePath = $this->converter->convertImageToPng($imagePath);

        $this->assertIsString($strFilePath);
        $this->assertFileExists($strFilePath);

        $this->assertEquals(IMAGETYPE_PNG, exif_imagetype($strFilePath));

        unlink($strFilePath);
    }

    public function testConvertImageWithInvalidFileType() {
        $this->expectException(ExtensionFileException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage("Invalid Image Format.");
        $this->converter->convertImageToPng(__FILE__);
    }

    public function testConverterFacade() {
        $faker = Factory::create();
        $imageUrl = $faker->imageUrl();
        $strFilePath = ConverterFacade::convertImageToPng("https://loremflickr.com/640/360");

        $this->assertIsString($strFilePath);
        $this->assertFileExists($strFilePath);

        $this->assertEquals(IMAGETYPE_PNG, exif_imagetype($strFilePath));

        unlink($strFilePath);
    }
}

<?php

namespace Gbetts\AncientDates\Tests;

use Gbetts\AncientDates\AncientDate;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class AncientDateTest extends TestCase
{
    #[DataProvider('validDatesProvider')]
    public function testConstructorAcceptsValidDates(string $date): void
    {
        $ancientDate = new AncientDate($date);
        $this->assertInstanceOf(AncientDate::class, $ancientDate);
    }

    #[DataProvider('invalidDatesProvider')]
    public function testConstructorRejectsInvalidDates(string $date): void
    {
        $this->expectException(\InvalidArgumentException::class);
        new AncientDate($date);
    }

    public function testYearsAgoCalculation(): void
    {
        $date = new AncientDate('-3000-01-01T00:00:00Z');
        $expectedYears = 3000 + (int)date('Y');
        $this->assertEquals($expectedYears, $date->yearsAgo());
    }

    #[DataProvider('toBceStringProvider')]
    public function testToBceString(string $date, string $expected): void
    {
        $ancientDate = new AncientDate($date);
        $this->assertEquals($expected, $ancientDate->toBceString());
    }

    #[DataProvider('periodProvider')]
    public function testPeriod(string $date, string $expectedPeriod): void
    {
        $ancientDate = new AncientDate($date);
        $this->assertEquals($expectedPeriod, $ancientDate->period());
    }

    public static function validDatesProvider(): array
    {
        return [
            'Recent BCE date' => ['-3000-01-01T00:00:00Z'],
            'Million years BCE' => ['-155000000-01-01T00:00:00Z'],
            'Different time' => ['-65000000-01-01T12:30:45Z'],
        ];
    }

    public static function invalidDatesProvider(): array
    {
        return [
            'Missing minus' => ['3000-01-01T00:00:00Z'],
            'Wrong format' => ['-3000/01/01T00:00:00Z'],
            'Missing T' => ['-3000-01-01 00:00:00Z'],
            'Missing Z' => ['-3000-01-01T00:00:00'],
            'Empty string' => [''],
            'Random string' => ['invalid date'],
        ];
    }

    public static function toBceStringProvider(): array
    {
        return [
            'Regular year' => [
                '-3000-01-01T00:00:00Z',
                '3000 years BCE'
            ],
            'Million years' => [
                '-155000000-01-01T00:00:00Z',
                '155 million years BCE'
            ],
        ];
    }

    public static function periodProvider(): array
    {
        return [
            'Modern period' => [
                '-4000-01-01T00:00:00Z',
                'Modern'
            ],
            'Quaternary period' => [
                '-2000000-01-01T00:00:00Z',
                'Quaternary'
            ],
            'Jurassic period' => [
                '-155000000-01-01T00:00:00Z',
                'Jurassic'
            ],
            'Precambrian period' => [
                '-700000000-01-01T00:00:00Z',
                'Precambrian'
            ],
        ];
    }
}
<?php


namespace Test\TheScore;


use PHPUnit\Framework\TestCase;
use Test\TheScore\PlayerData\Repository\JsonFileFactory;

class TheScoreTestCase extends TestCase
{
    protected function tearDown(): void
    {
        parent::tearDown();
        JsonFileFactory::deleteAllFilesGenerated();
    }
}

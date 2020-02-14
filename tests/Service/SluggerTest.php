<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Service\Slugger;
use PHPUnit\Framework\TestCase;

class SluggerTest extends TestCase
{
    public function testSlugiify(): void
    {
        $slugger = new Slugger();
        $this->assertEquals('adultes', $slugger->slugify('Adultes'));
        $this->assertEquals('l-accueil-des-enfants', $slugger->slugify("l'accueïl des Enfânts "));
    }
}

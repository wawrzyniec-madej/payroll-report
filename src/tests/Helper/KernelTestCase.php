<?php

namespace App\Tests\Helper;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase as BaseKernelTestCase;

abstract class KernelTestCase extends BaseKernelTestCase
{
    /** @param class-string $name */
    public function getService(string $name): mixed
    {
        return $this->getContainer()->get($name);
    }
}
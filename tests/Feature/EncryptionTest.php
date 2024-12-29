<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Crypt;
use Tests\TestCase;

class EncryptionTest extends TestCase
{
    public function testEncryption()
    {
        $encrypt = Crypt::encrypt('Thariq Maulana');
        var_dump($encrypt);

        $decrypt = Crypt::decrypt($encrypt);

        self::assertEquals('Thariq Maulana', $decrypt);
    }
}

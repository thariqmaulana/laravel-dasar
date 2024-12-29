<?php

namespace App\Data;

class Larav
{
  public Belajar $belajar;

  public function __construct(Belajar $belajar)
  {
    $this->belajar = $belajar;
  }

  public function larav(): string
  {
    return $this->belajar->belajar() . ' Larav';
  }
}


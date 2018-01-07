<?php

namespace Classes\Output;


interface OutputInterface
{
    public function __construct();

    public function formatValue();
}
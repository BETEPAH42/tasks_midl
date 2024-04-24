<?php

$newException = new class extends Exception
{
    protected $context;

    public function __construct($message = "Ошибка сервера", $code = 500, $context = null)
    {
        parent::__construct($message, $code);
        $this->context = $context;
    }

    public function getContext()
    {
        return $this->context;
    }
};

$testAnonymusException = new $newException('Ошибка сервера', 500, 'Здесь будет контекст');

//echo "<pre>";
//var_dump($testAnonymusException->getContext());
//echo "</pre>";

throw $testAnonymusException;
<?php
$dailySBR = new class('https://cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL') extends SoapClient
{
    public function KeyRate($arguments) {
        $result = parent::KeyRate($arguments);
        $result = $this->xmlToArray($result->KeyRateResult);
        return $result;
    }

    protected function xmlToArray($xml)
    {
        $prepearData = \simplexml_load_string($xml->any, "SimpleXMLElement", LIBXML_NOCDATA);
        $array = json_decode(json_encode($prepearData),TRUE);
        $result = array_reduce($array["KeyRate"]['KR'], function ($newArray,$item){
                $newArray[(new DateTime($item['DT']))->format('d.m.Y')] = number_format($item['Rate'],2);
                return $newArray;
        });
        return $result;
    }
};
try {
    $filter = [
        'fromDate' => '2024-04-01T00:00:00',
        'ToDate' => '2024-04-30T00:00:00',
    ];
    $result = $dailySBR->KeyRate($filter);
    var_dump($result);
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}

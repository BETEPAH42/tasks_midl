<?php
$dailySBR = new class extends SoapClient
{
    public function __construct($wsdl = 'https://cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL', array $options = null)
    {
        $this->SoapClient($wsdl);
    }

    public function toArray(array $filter): array
    {
        $res = $this->KeyRate($filter);
        $xml = \simplexml_load_string($res->KeyRateResult->any, "SimpleXMLElement", LIBXML_NOCDATA);
        $array = json_decode(json_encode($xml),TRUE);
        $resultArray = array_map(function ($item){
            return [
                'date' => (new DateTime($item['DT']))->format('d.m.Y'),
                'Rate' => number_format($item['Rate'],2)
            ];
        },$array['KeyRate']['KR']);
        return array_reverse($resultArray);
    }
};
try {
    $client2 = new $dailySBR();
    $filter = [
        'fromDate' => '2024-04-01T00:00:00',
        'ToDate' => '2024-04-30T00:00:00',
    ];
    $result = $client2->toArray($filter);
    var_dump($result);
} catch (Throwable $throwable) {
    echo $throwable->getMessage();
}

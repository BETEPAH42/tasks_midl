<?php
$dailySBR = new class('https://cbr.ru/DailyInfoWebServ/DailyInfo.asmx?WSDL') extends SoapClient
{
    public function __call($function_name, $arguments) {
        $result = parent::__call($function_name, $arguments);
        if($function_name == "KeyRate") {
            $xml = \simplexml_load_string($result->KeyRateResult->any, "SimpleXMLElement", LIBXML_NOCDATA);
            $array = json_decode(json_encode($xml),TRUE);
            $resultKR = array_map(function ($item){
                return [
                    'date' => (new DateTime($item['DT']))->format('d.m.Y'),
                    'Rate' => number_format($item['Rate'],2)
                ];
            },$array['KeyRate']['KR']);
            $result = array_reverse($resultKR);
        }
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

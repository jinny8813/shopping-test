<?php

namespace App\Controllers\FrontStage;

use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Services\CheckMacValueService;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

use App\Models\OrdersModel;

class EcPayController extends BaseController{
    use ResponseTrait;

    public function orderPay(string $tradeNo, int $total){
        $factory = new Factory([
            'hashKey' => 'spPjZn66i0OhqJsQ',
            'hashIv'  => 'hT5OJckN45isQTTs',
        ]);

        $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

        $describe = "騏騏測試，共新台幣(NTD) " . $total . " 元";

        $input = [
            'MerchantID'        => '3002599',
            'MerchantTradeNo'   => $tradeNo,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType'       => 'aio',
            'TotalAmount'       => $total,
            'TradeDesc'         => UrlService::toDotNetUrlEncode($describe),
            'ItemName'          => $describe,
            'ChoosePayment'     => 'ALL',
            'EncryptType'       => 1,
            'ReturnURL'         => base_url("callbackAfterPayment"),//'https://53dd-36-238-145-155.ngrok-free.app/callbackAfterPayment',
            'OrderResultURL'    => base_url("afterPayment")//'https://53dd-36-238-145-155.ngrok-free.app/callbackAfterPayment',
        ];
        $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

        echo $autoSubmitFormService->generate($input, $action);
    }

    public function afterPayment(){
        $RtnCode              = $this->request->getPostGet('RtnCode');
        $MerchantTradeNo      = $this->request->getPostGet('MerchantTradeNo');
        $PaymentDate          = $this->request->getPostGet('PaymentDate');
        $CheckMacValue        = $this->request->getPostGet('CheckMacValue');
        $PaymentType          = $this->request->getPostGet('PaymentType');

        if (is_null($RtnCode) || is_null($MerchantTradeNo) || is_null($PaymentDate) || is_null($CheckMacValue) || is_null($PaymentType)) {
            return $this->fail("付款失敗", 404);
        }

        //產生檢查碼物件，並產生檢查碼
        $CheckMacValueService = new CheckMacValueService('spPjZn66i0OhqJsQ', 'hT5OJckN45isQTTs', 'sha256');
        $getPostCheckMacValue = $CheckMacValueService->generate($_POST);

        //判斷綠界回傳狀態是否為 1 以及 檢查碼是否相符
        if ($RtnCode == 1 && $getPostCheckMacValue == $CheckMacValue) {

            $ordersModel = new OrdersModel();
            $checkOrderData = $ordersModel->where('o_trade_number',$MerchantTradeNo)->first();

            $values = [
                'o_status'      =>  "付款成功",
            ];
            $checkOrderDataUpdate = $ordersModel->update($checkOrderData['o_id'], $values);

            if ($checkOrderDataUpdate){
                return $this->respond([
                    "status" => true,
                    "data"   => "付款成功",
                    "msg"    => "付款成功"
                ]);
            }else {
                return $this->fail("付款失敗", 404);
            }
        } else {
            return $this->fail("付款失敗", 404);
        }
    }
}
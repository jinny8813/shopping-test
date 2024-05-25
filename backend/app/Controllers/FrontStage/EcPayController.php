<?php

namespace App\Controllers\FrontStage;

use Ecpay\Sdk\Factories\Factory;
use Ecpay\Sdk\Services\UrlService;
use Ecpay\Sdk\Services\CheckMacValueService;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;

class EcPayController extends BaseController{
    use ResponseTrait;

    public function orderPay(string $tradeNo, int $total){
        $factory = new Factory([
            'hashKey' => '5294y06JbISpM5x9',
            'hashIv'  => 'v77hoKGq4kWxNNIS',
        ]);

        $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

        $describe = "騏騏測試，共新台幣(NTD) " . $total . " 元";

        $input = [
            'MerchantID'        => '2000132',
            'MerchantTradeNo'   => $tradeNo,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType'       => 'aio',
            'TotalAmount'       => $total,
            'TradeDesc'         => UrlService::toDotNetUrlEncode($describe),
            'ItemName'          => $describe,
            'ChoosePayment'     => 'ALL',
            'EncryptType'       => 1,
            'ReturnURL'         => 'https://ngrok.com/r/ti/callbackAfterPayment', //base_url("api/ECPay/callbackAfterPayment"),
        ];
        $action = 'https://payment-stage.ecpay.com.tw/Cashier/AioCheckOut/V5';

        echo $autoSubmitFormService->generate($input, $action);
    }

    public function callbackAfterPayment()
    {
        $RtnCode              = $this->request->getPostGet('RtnCode');
        $MerchantTradeNo      = $this->request->getPostGet('MerchantTradeNo');
        $PaymentDate          = $this->request->getPostGet('PaymentDate');
        $CheckMacValue        = $this->request->getPostGet('CheckMacValue');
        $PaymentType          = $this->request->getPostGet('PaymentType');

        $_POST = [
            'MerchantID' => '2000132',
            'MerchantTradeNo' => 'WPLL4E341E122DB44D62',
            'PaymentDate' => '2019/05/09 00:01:21',
            'PaymentType' => 'Credit_CreditCard',
            'PaymentTypeChargeFee' => '1',
            'RtnCode' => '1',
            'RtnMsg' => '交易成功',
            'SimulatePaid' => '0',
            'TradeAmt' => '500',
            'TradeDate' => '2019/05/09 00:00:18',
            'TradeNo' => '1905090000188278',
            'CheckMacValue' => '59B085BAEC4269DC1182D48DEF106B431055D95622EB285DECD400337144C698',
        ];

        if (is_null($RtnCode) || is_null($MerchantTradeNo) || is_null($PaymentDate) || is_null($CheckMacValue) || is_null($PaymentType)) {
            return $this->response->setJSON("0|Fail");
        }

        // $DonationDetailsModel = new DetailsModel();

        //產生檢查碼物件，並產生檢查碼
        $CheckMacValueService = new CheckMacValueService('5294y06JbISpM5x9', 'v77hoKGq4kWxNNIS', 'sha256');
        $getPostCheckMacValue = $CheckMacValueService->generate($_POST);

        //判斷綠界回傳狀態是否為 1 以及 檢查碼是否相符
        if ($RtnCode == 1 && $getPostCheckMacValue == $CheckMacValue) {
            // $DetailsEntity = new DetailsEntity();
            // $DetailsEntity->tradeNumber           = $MerchantTradeNo;
            // $DetailsEntity->date_of_ecpay_receipt = $PaymentDate;
            // $DetailsEntity->donation_status       = $this::$donationStatus['done'];
            // $DetailsEntity->ecpay_status_code     = $RtnCode;
            // $DetailsEntity->payment_type          = $PaymentType;

            // $updateDetailRes =  $DonationDetailsModel->where('tradeNumber', $MerchantTradeNo)
            //     ->save($DetailsEntity);

            if ($updateDetailRes) {
                $response =  "1|OK";
            } else {
                $response =  "0|Fail";
            }

            // $mailController = new MailController();

            // $mailController->donateMailSend($MerchantTradeNo);
        } else {
            // $DonationDetailsModel->singleFailTransaction($MerchantTradeNo, $PaymentDate, $RtnCode, $PaymentType);

            $response =  "0|Fail";
        }
        return $this->response->setJSON($response);
    }

}
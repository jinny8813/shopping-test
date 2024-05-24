<?php

namespace App\Controllers\FrontStage;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use App\Models\OrdersModel;



class OrdersController extends BaseController
{
    use ResponseTrait;

    public function SinglePay(string $tradeNo)
    {
        $DonationDetailsModel = new DetailsModel();
        $detailData           = $DonationDetailsModel->find($tradeNo);

        $DonationPurposeModel = new PurposeModel();
        $purposeItem          = $DonationPurposeModel->find($detailData->DonationPurpose_id);

        $factory = new Factory([
            'hashKey' => getenv('HASH_KEY'),
            'hashIv'  => getenv('HASH_IV'),
        ]);

        $autoSubmitFormService = $factory->create('AutoSubmitFormWithCmvService');

        $describe = "捐贈本校軟體工程與管理學系 " . $purposeItem->name . " 經費，共新台幣(NTD) " . $detailData->donation_amount . " 元整";

        $input = [
            'MerchantID'        => getenv('MERCHANT_ID'),
            'MerchantTradeNo'   => $tradeNo,
            'MerchantTradeDate' => date('Y/m/d H:i:s'),
            'PaymentType'       => 'aio',
            'TotalAmount'       => $detailData->donation_amount,
            'TradeDesc'         => UrlService::toDotNetUrlEncode($describe),
            'ItemName'          => $describe,
            'ChoosePayment'     => 'ALL',
            'EncryptType'       => 1,
            'ClientBackURL'     => getenv('CLIENT_BACK_URL'),
            'ReturnURL'         => base_url("api/ECPay/callbackAfterPayment"),
        ];
        $action = getenv('ACTION_URL');

        echo $autoSubmitFormService->generate($input, $action);
    }


}
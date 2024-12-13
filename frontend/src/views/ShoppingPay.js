import { DollarOutlined, RightCircleFilled } from '@ant-design/icons'

export default function ShoppingPay() {
    return (
        <main className='shopping-pay-main'>
            <h2 className='shopping-pay-title'><DollarOutlined /> 請選擇付款方式</h2>
            <div className='shopping-pay-options'>
                <div className='shopping-pay-option'>
                    <input className='shopping-pay-option-input' id='line-pay' type='radio' name='payment-method' value='line-pay' />
                    <label for='line-pay' className='shopping-pay-option-label'><img className='shopping-pay-option-logo line-pay-logo' src='/assets/line-pay.png'></img> LINE Pay (信用卡)</label>
                </div>
                <div className='shopping-pay-option'>
                    <input className='shopping-pay-option-input' id='jko-pay' type='radio' name='payment-method' value='jko-pay' />
                    <label for='jko-pay' className='shopping-pay-option-label'><img className='shopping-pay-option-logo jko-pay-logo' src='/assets/jko-pay.png'></img> 街口支付 (JKO Pay)</label>
                </div>
                <div className='shopping-pay-option'>
                    <input className='shopping-pay-option-input' id='apple-pay' type='radio' name='payment-method' value='apple-pay' />
                    <label for='apple-pay' className='shopping-pay-option-label'><img className='shopping-pay-option-logo apple-pay-logo' src='/assets/apple-pay.png'></img> Apple Pay</label>
                </div>
            </div>
            <div className='shopping-pay-bottom'>
                <button className='shopping-pay-btn'><RightCircleFilled /> 繼續</button>
            </div>
        </main>
    )
}
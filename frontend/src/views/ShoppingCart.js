import { ShoppingCartOutlined, ReloadOutlined, CreditCardFilled } from '@ant-design/icons'
import { InputNumber } from 'antd'
import { Link } from 'react-router-dom'

const items = [
    {
        image: '/assets/appleii.png',
        name: '佔位產品',
        price: 500,
        description: '這個產品很酷，品質很好',
        quantity: 2,
        id: 123
    },
    {
        image: '/assets/appleii.png',
        name: '佔位產品',
        price: 500,
        description: '這個產品很酷，品質很好',
        quantity: 2,
        id: 123
    },
    {
        image: '/assets/appleii.png',
        name: '佔位產品',
        price: 500,
        description: '這個產品很酷，品質很好',
        quantity: 2,
        id: 123
    }
]

const totalPrice = items.reduce((sum, item) => sum + item.price, 0);

export default function ShoppingCart() {
    const cartItems = items.map(item =>
        <tr class='shopping-cart-item'>
            <td width={150} className='shopping-cart-item-image'><img className='shopping-cart-item-image-core' src={item.image}></img></td>
            <td width={100} className='shopping-cart-item-name'>{item.name}</td>
            <td width={55} className='shopping-cart-item-price'><span>{item.price}</span><span>元</span></td>
            <td width={150} className='shopping-cart-item-description'>{item.description}</td>
            <td width={55} className='shopping-cart-item-quantity'>
                <InputNumber className='shopping-cart-item-quantity-core' defaultValue={item.quantity} />
            </td>
            <td className='shopping-cart-item-link'>
                <Link className='shopping-cart-item-link-core' to={`/store/${item.id}`}><ReloadOutlined /> 回產品頁面</Link>
            </td>
        </tr>
    )

    return (
        <main class='shopping-cart-main'>
            <div class='shopping-cart-top'>
                <h2 class='shopping-cart-top-title'><ShoppingCartOutlined /> 購物車內容</h2>
            </div>
            <table class='shopping-cart-items'>
                <thead>
                    <tr>
                        <th>零件照片</th>
                        <th>零件名字</th>
                        <th>價格</th>
                        <th>說明</th>
                        <th>數量</th>
                    </tr>
                </thead>
                <tbody>
                    {cartItems}
                </tbody>
            </table>
            <div class='shopping-cart-bottom'>
                <table class='shopping-cart-items'>
                    <tbody>
                        <td width={150} className='shopping-cart-item-image'></td>
                        <td width={100} className='shopping-cart-item-name'></td>
                        <td width={55} className='shopping-cart-item-price'><span>{totalPrice}</span><span>元</span></td>
                        <td width={150} className='shopping-cart-item-description'></td>
                        <td className='shopping-cart-item-quantity'></td>
                        <td className='shopping-cart-item-link'>
                            <Link to={'/shopping/pay'}>
                                <button class='shopping-cart-checkout-btn'><CreditCardFilled /> 結帳</button>
                            </Link>
                        </td>
                    </tbody>
                </table>
            </div>
        </main>
    )
}
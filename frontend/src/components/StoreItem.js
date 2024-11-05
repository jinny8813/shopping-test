import { ShoppingCartOutlined } from '@ant-design/icons'

export default function StoreItem({ name='佔位產品', image='./assets/appleii.png', description='這是一項佔位產品', price=500 }) {
    return (
        <div className='store-item'>
            <h3 className='store-item-title'>{ name }</h3>
            <img className='store-item-image' src={image}></img>
            <p className='store-item-description'>{ description }</p>
            <div className='store-item-bottom'>
                <p className='store-item-bottom-price'><span className='store-item-bottom-price-sign'>$</span>{price}</p>
                <button className='store-item-bottom-btn'><ShoppingCartOutlined className='store-item-bottom-btn-icon' />加入購物車</button>
            </div>
        </div>
    )
}
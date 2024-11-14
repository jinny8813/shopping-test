import { Link } from 'react-router-dom'
import { ShoppingCartOutlined } from '@ant-design/icons'

export default function StoreItem({ name = '佔位產品', id = 123, image = './assets/appleii.png', description = '是一項佔位產品，很值錢與品質高！', price = 500 }) {
    return (
        <div className='store-item'>
            <h3 className='store-item-title'>{name}</h3>
            <Link to={`/store/${id}`}>
                <img className='store-item-image' src={image}></img>
            </Link>
            <p className='store-item-description'>{description}</p>
            <div className='store-item-bottom'>
                <p className='store-item-bottom-price'>{price}<span className='store-item-bottom-price-sign'>元</span></p>
                <button className='store-item-bottom-btn'><ShoppingCartOutlined className='store-item-bottom-btn-icon' />加入購物車</button>
            </div>
        </div>
    )
}
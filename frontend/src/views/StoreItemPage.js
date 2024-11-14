import { InputNumber } from 'antd'
import { ShoppingCartOutlined } from '@ant-design/icons'

export default function StoreItemPage() {
    return (
        <main className='store-item-page'>
            <div className='store-item-page-listing'>
                <div className='store-item-page-listing-image-container'>
                    <img className='store-item-page-listing-image' src='/assets/appleii.png'>
                    </img>
                </div>
                <div className='store-item-page-listing-info'>
                    <h3 className='store-item-page-listing-info-name'>佔位產品</h3>
                    <p className='store-item-page-listing-info-description'>是一項佔位產品，很值錢與品質高！有了這個零件就可以增加您生活效率，進步健康，實現大繁榮。</p>
                    <p className='store-item-page-listing-info-price'>500元</p>

                    <div className='store-item-page-listing-info-specifications'>
                        <table className='store-item-page-specifications-table'>
                            <thead className='store-item-page-specifications-table-header'>
                                <tr>
                                    <th className='store-item-page-specifications-table-header-field' scope='col'>欄位</th>
                                    <th className='store-item-page-specifications-table-header-data' scope='col'>資料</th>
                                </tr>
                            </thead>
                            <tbody className='store-item-page-specifications-table-body'>
                                <tr>
                                    <th scope='row'>CPU 核心數</th>
                                    <td>4 核心</td>
                                </tr>
                                <tr>
                                    <th scope='row'>時派速度</th>
                                    <td>2.0 GHz</td>
                                </tr>
                                <tr>
                                    <th scope='row'>多執行者</th>
                                    <td>基本 Multithreading</td>
                                </tr>
                                <tr>
                                    <th scope='row'>快取記憶體</th>
                                    <td>256KB</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <InputNumber className='store-item-page-listing-info-quantity' addonBefore="數量" defaultValue={1} />

                    <button className='store-item-page-listing-info-cart'><ShoppingCartOutlined /> 加入購物車</button>
                </div>
            </div>
        </main>
    )
}
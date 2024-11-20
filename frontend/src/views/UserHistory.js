import { Input } from 'antd'
import { SearchOutlined, SelectOutlined } from '@ant-design/icons'

export default function UserHistory() {
    return (
        <main className='user-history'>
            <div className='user-history-top'>
                <h2 className='user-history-title'>訂單記錄</h2>
                <Input className='user-history-searchbar' addonAfter={<SearchOutlined />}></Input>
            </div>
            <form className='user-history-form'>
                <table className='user-history-table'>
                    <colgroup>
                        <col span={4} />
                        <col className='user-history-table-details' />
                    </colgroup>
                    <thead>
                        <tr>
                            <th scope='col'>訂單ID</th>
                            <th scope='col'>日期/時間</th>
                            <th scope='col'>價格</th>
                            <th scope='col'>狀態</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-shipping'>送貨中</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-shipping'>送貨中</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-shipping'>送貨中</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-arrived'>已抵達</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-arrived'>已抵達</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-fail'>送貨失敗</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-arrived'>已抵達</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                        <tr className='user-history-table-tr'>
                            <td className='user-history-table-id'>234214905dwaf0</td>
                            <td className='user-history-table-date'>12月24號2025年</td>
                            <td className='user-history-table-price'>750元</td>
                            <td className='user-history-table-status status-arrived'>已抵達</td>
                            <td className='user-history-table-details'><button><SelectOutlined /> 看細節</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </main>
    )
}
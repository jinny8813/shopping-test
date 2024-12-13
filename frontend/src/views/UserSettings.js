import { EditFilled } from '@ant-design/icons'

export default function UserSettings() {
    return (
        <main className='user-settings'>
            <div className='user-settings-top'>
                <h2 className='user-settings-title'>使用者資料修改</h2>
            </div>
            <form className='user-settings-form'>
                <table className='user-settings-table'>
                    <tr>
                        <td className='user-settings-table-field'>姓名</td>
                        <td className='user-settings-table-data'>柯文哲</td>
                        <td className='user-settings-table-edit-btn'><button type='submit'><EditFilled /> 修改</button></td>
                    </tr>
                    <tr>
                        <td className='user-settings-table-field'>密碼</td>
                        <td className='user-settings-table-data'>k**********p</td>
                        <td className='user-settings-table-edit-btn'><button type='submit'><EditFilled /> 修改</button></td>
                    </tr>
                    <tr>
                        <td className='user-settings-table-field'>電子郵件</td>
                        <td className='user-settings-table-data'>kp@gmail.com</td>
                        <td className='user-settings-table-edit-btn'><button type='submit'><EditFilled /> 修改</button></td>
                    </tr>
                    <tr>
                        <td className='user-settings-table-field'>LINE帳號</td>
                        <td className='user-settings-table-data'>kewenzhe</td>
                        <td className='user-settings-table-edit-btn'><button type='submit'><EditFilled /> 修改</button></td>
                    </tr>
                    <tr>
                        <td className='user-settings-table-field'>電話號碼</td>
                        <td className='user-settings-table-data'>0979123456</td>
                        <td className='user-settings-table-edit-btn'><button type='submit'><EditFilled /> 修改</button></td>
                    </tr>
                </table>
            </form>
        </main>
    )
}
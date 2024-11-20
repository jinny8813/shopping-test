import { EditFilled } from '@ant-design/icons'

export default function UserSettings() {
    return (
        <main className='user-settings'>
            <h2 className='user-settings-title'>使用者資料修改</h2>
            <hr className='user-settings-break'></hr>
            <form className='user-settings-form'>
                <table>
                    <tbody>
                        <tr>
                            <td className='user-settings-form-field'>姓名</td>
                            <td className='user-settings-form-data'>柯文哲</td>
                            <td className='user-settings-form-edit-btn'><button className='user-settings'><EditFilled /> 修改</button></td>
                        </tr>
                        <tr>
                            <td className='user-settings-form-field'>密碼</td>
                            <td className='user-settings-form-data'>**********</td>
                            <td className='user-settings-form-edit-btn'><button className='user-settings'><EditFilled /> 修改</button></td>
                        </tr>
                        <tr>
                            <td className='user-settings-form-field'>電子郵件</td>
                            <td className='user-settings-form-data'>kp@gmail.com</td>
                            <td className='user-settings-form-edit-btn'><button className='user-settings'><EditFilled /> 修改</button></td>
                        </tr>
                        <tr>
                            <td className='user-settings-form-field'>LINE帳號</td>
                            <td className='user-settings-form-data'>kewenzhe</td>
                            <td className='user-settings-form-edit-btn'><button className='user-settings'><EditFilled /> 修改</button></td>
                        </tr>
                        <tr>
                            <td className='user-settings-form-field'>電話號碼</td>
                            <td className='user-settings-form-data'>0979123456</td>
                            <td className='user-settings-form-edit-btn'><button className='user-settings'><EditFilled /> 修改</button></td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </main>
    )
}
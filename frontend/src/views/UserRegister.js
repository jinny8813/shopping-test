import { SendOutlined, UserOutlined, KeyOutlined, MailOutlined } from "@ant-design/icons"
import { Input } from "antd"

export default function UserRegister() {
    return (
        <main className="user-register-main">
            <form className="user-register-form">
                <h2 className="user-register-form-title">使用者註冊</h2>
                <div className="user-register-form-inputs">
                    <Input size="medium" addonBefore={<UserOutlined />} className="user-register-form-input" placeholder="名字"></Input>
                    <Input size="medium" addonBefore={<KeyOutlined />} className="user-register-form-input" type="password" placeholder="密碼"></Input>
                    <Input size="medium" addonBefore={<MailOutlined />} className="user-register-form-input" type="email" placeholder="電子郵件"></Input>
                </div>
                <div className="user-register-form-thirdp">
                    <button className="user-register-form-thirdp-btn user-register-form-thirdp-line"><img className="user-register-form-thirdp-line-logo" src="/assets/line.png"></img><span className="user-register-form-thirdp-line-text">與LINE帳號登入</span></button>
                    <button className="user-register-form-thirdp-btn user-register-form-thirdp-google">Google</button>
                </div>
                <button className="user-register-form-btn"><SendOutlined /> 註冊帳號</button>
            </form>
        </main>
    )
}
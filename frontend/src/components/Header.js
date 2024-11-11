import { Link } from 'react-router-dom'

export default function Header({ signedIn = true }) {
    return (
        <header className='header'>
            <div className='header-logo'>
                <img className='header-logo-image' src="/assets/logo.png"></img>
                <h3 className='header-logo-text'>騏騏資訊</h3>
            </div>
            <nav className='header-nav'>
                <Link className='header-nav-link' to={'/store'}>線上商店</Link>
                <Link className='header-nav-link' to={'/faqs'}>常見問題</Link>
                <Link className='header-nav-link' to={'/terms'}>訂購須知</Link>
                {signedIn ?
                    <div className='header-nav-profile'>
                        <img className='header-nav-profile-image' src='/assets/kp.jpg'></img>
                        <div>
                            <strong className='header-nav-profile-name'>柯文哲</strong>
                            <p className='header-nav-profile-greeting'>歡迎回來,貴客</p>
                        </div>
                    </div>
                    :
                    <Link className='header-nav-link' to={'/register'}>登入/註冊？</Link>
                }
            </nav>
        </header>
    )
}
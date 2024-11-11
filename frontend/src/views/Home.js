import StoreItem from "../components/StoreItem"

export default function Home() {
    return (
        <main className='home-main'>
            <img src='./assets/ad-banner.jpg' className='home-hero-banner'></img>
            <div className='home-newest'>
                <h2 className='home-newest-title'>最新最紅的產品</h2>
                <div className='home-newest-list'>
                    <StoreItem />
                    <StoreItem />
                    <StoreItem />
                </div>
            </div>
        </main>
    )
}
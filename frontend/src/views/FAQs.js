import Accordion from '../components/Accordion'

const items = [
    {
        title: '第一號問題',
        content: '這個是一個很重要的問題，如果你沒有先讀者個在線上商店買東西會出事的。',
    },
    {
        title: '第二個問題',
        content: '這個問題也很重要，請仔細讀答案。',
    },
    {
        title: '第三項問題',
        content: '瓦萊里呼嚕哈拉啊我餓分喔就離開加薩分綠卡健身，房科技哈喔i阿萬人梗破就阿萬人啊違法違法迫擊破愛。人啦看完日劇不認為啦空間挖吧，啦空間萬阿人。瓦萊里呼嚕哈拉啊我餓分喔i就離開加薩分綠卡健身，房科技哈喔阿萬人梗破就阿萬人啊違法違法迫擊破愛。人啦看完日劇不認為啦空間挖吧，啦空間萬阿人。',
    },
]

export default function FAQs() {
    return (
        <main className='faqs-main'>
            <div className='faqs-heading'>
                <h2 className='faqs-heading-title'>常見問題 (FAQs)</h2>
                <p className='faqs-heading-subtitle'>如果你有哪些問題，請先在這邊看看有沒有答案再寄電子郵件。</p>
            </div>
            <Accordion items={items} />
        </main>
    )
}
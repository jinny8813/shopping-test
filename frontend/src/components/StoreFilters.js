export default function StoreFilters() {
    return (
        <div className='store-filters'>
            <h2 className='store-filters-title'>客製化主機設定</h2>
            <form className='store-filters-content'>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>螢幕尺寸</option>
                    <option className='store-filters-content-option'>24 吋</option>
                    <option className='store-filters-content-option'>27 吋</option>
                    <option className='store-filters-content-option'>32 吋</option>
                    <option className='store-filters-content-option'>49 吋</option>
                </select>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>一幕解析度</option>
                    <option className='store-filters-content-option'>1920 x 1080 (全高清)</option>
                    <option className='store-filters-content-option'>2560 x 1440 (QHD)</option>
                    <option className='store-filters-content-option'>3840 x 2160 (4K UHD) 以上</option>
                </select>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>CPU 核心數</option>
                    <option className='store-filters-content-option'>4 核心</option>
                    <option className='store-filters-content-option'>6 核心</option>
                    <option className='store-filters-content-option'>8 核心 以上</option>
                </select>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>時派速度</option>
                    <option className='store-filters-content-option'>2.0GHz</option>
                    <option className='store-filters-content-option'>3.0GHz</option>
                    <option className='store-filters-content-option'>4.0GHz</option>
                    <option className='store-filters-content-option'>5.0GHz 以上</option>
                </select>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>多執行緒</option>
                    <option className='store-filters-content-option'>沒有</option>
                    <option className='store-filters-content-option'>基本 Multithreading</option>
                    <option className='store-filters-content-option'>Hyper-Threading (Intel)</option>
                    <option className='store-filters-content-option'>Simultaneous Multithreading (AMD)</option>
                </select>
                <select className='store-filters-content-select'>
                    <option className='store-filters-content-option' selected disabled>快取記憶體</option>
                    <option className='store-filters-content-option'>16KB - 128KB</option>
                    <option className='store-filters-content-option'>256KB - 1MB</option>
                    <option className='store-filters-content-option'>2MB - 64MB</option>
                </select>
            </form>
        </div>
    )
}
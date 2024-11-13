import { useState } from 'react'

const Accordion = ({ items }) => {
    const [activeIndex, setActiveIndex] = useState(null)

    const handleToggle = (index) => {
        setActiveIndex(activeIndex === index ? null : index)
    }

    return (
        <div className="accordion">
            {items.map((item, index) => (
                <div key={index} className="accordion-item">
                    <div
                        className="accordion-header"
                        onClick={() => handleToggle(index)}
                    >
                        {item.title}
                        <span className={`accordion-icon ${activeIndex === index ? 'open' : ''}`}>
                            {activeIndex === index ? '-' : '+'}
                        </span>
                    </div>
                    <div
                        className={`accordion-content ${activeIndex === index ? 'active' : ''}`}
                    >
                        {item.content}
                    </div>
                </div>
            ))}
        </div>
    )
}

export default Accordion

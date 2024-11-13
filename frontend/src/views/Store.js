import React from 'react'

import StoreFilters from '../components/StoreFilters'
import StoreItem from '../components/StoreItem'

export default function Store() {
    return (
        <React.Fragment>
            <StoreFilters />
            <main className='store-main'>
                <StoreItem></StoreItem>
                <StoreItem></StoreItem>
                <StoreItem></StoreItem>
                <StoreItem></StoreItem>
                <StoreItem></StoreItem>
            </main>
        </React.Fragment>
    )
}
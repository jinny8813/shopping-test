import React from 'react'
import {
  createBrowserRouter,
  RouterProvider,
} from "react-router-dom";

import Home from './views/Home.js'
import FAQs from './views/FAQs.js'
import Terms from './views/Terms.js'
import Store from './views/Store.js'
import StoreItemPage from './views/StoreItemPage.js'
import ShoppingCart from './views/ShoppingCart.js'
import ShoppingPay from './views/ShoppingPay.js'
import UserLogin from './views/UserLogin.js'
import UserRegister from './views/UserRegister.js'
import UserHistory from './views/UserHistory.js'
import UserSettings from './views/UserSettings.js'

import Layout from './components/Layout.js';

const router = createBrowserRouter([
  {
    path: "/",
    element: <Layout />,
    children: [
      { 
        index: true, 
        element: <Home /> 
      },
      {
        path: "/faqs",
        element: <FAQs />,
      },
      {
        path: "/terms",
        element: <Terms />,
      },
      {
        path: "/store",
        element: <Store />,
      },
      {
        path: "/store/:id",
        element: <StoreItemPage />,
      },
      {
        path: "/shopping/cart",
        element: <ShoppingCart />,
      },
      {
        path: "/shopping/pay",
        element: <ShoppingPay />,
      },
      {
        path: "/user/login",
        element: <UserLogin />,
      },
      {
        path: "/user/register",
        element: <UserRegister />,
      },
      {
        path: "/user/history",
        element: <UserHistory />,
      },
      {
        path: "/user/settings",
        element: <UserSettings />,
      },
    ]
  }
]);

function App() {
  return (
    <React.StrictMode>
      <RouterProvider router={router} />
    </React.StrictMode>
  );
}

export default App;

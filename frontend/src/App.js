import { createBrowserRouter, RouterProvider } from "react-router-dom";
import { GoogleOAuthProvider } from "@react-oauth/google";

import { FloatButton } from "antd";
import LineIcon from "./Components/UI/btn_base.png";
import "./App.css";
import Root from "./Page/Layout/Root";
import Home from "./Page/Home";
import { Store as HostStore } from "./Page/host/Store";
import Host from "./Page/host/Host";
import Product from "./Page/Product";
import Store from "./Page/Store";
import Cart from "./Page/Cart";
import User from "./Page/User";
import PaymentSuccess from "./Page/PaymentSuccess";

const router = createBrowserRouter([
  {
    path: "/",
    element: <Root />,
    children: [
      { index: true, element: <Home /> },
      {
        path: "host_store",
        element: <HostStore />,
      },
      {
        path: "host_store/:hostId",
        element: <Host />,
      },
      {
        path: "store",
        element: <Store />,
      },
      {
        path: "store/:productId",
        element: <Product />,
      },
      {
        path: "user",
        element: <User />,
      },
      {
        path: "cart",
        element: <Cart />,
      },
      {
        path: "pay-success",
        element: <PaymentSuccess />,
      },
    ],
  },
]);

function App() {
  return (
    <GoogleOAuthProvider clientId={process.env.REACT_APP_GOOGLE_ID}>
      <FloatButton
        shape="square"
        type="primary"
        style={{
          right: 24,
        }}
        icon={
          <a href="https://lin.ee/MTCAaGA" target="blank">
            <img src={`${LineIcon}`} style={{ width: "100%" }} />
          </a>
        }
      />
      <RouterProvider router={router} />
    </GoogleOAuthProvider>
  );
}

export default App;

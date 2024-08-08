import { Menu } from "antd";
import { Header } from "antd/es/layout/layout";
import { UserOutlined, ShoppingCartOutlined } from "@ant-design/icons";
import { Link } from "react-router-dom";

import { GoogleLogin } from "@react-oauth/google";
import LineButton from "./LineButton";

const Nav = () => {
  const items = [
    {
      label: <Link to="/">首頁</Link>,
      key: "home",
    },
    {
      label: "線上商店",
      key: "store",
      children: [
        {
          label: <Link to="host_store">客製化主機</Link>,
          key: "store:1",
        },
        {
          label: <Link to="store">零組件</Link>,
          key: "store:2",
        },
      ],
    },
    {
      label: "購買須知",
      key: "info",
    },
    {
      label: "常見問題",
      key: "question",
    },
    {
      label: (
        <GoogleLogin
          onSuccess={(credentialResponse) => {
            console.log(credentialResponse);
          }}
          onError={() => {
            console.log("Login Failed");
          }}
        />
      ),
      key: "google",
      style: { padding: "0px", margin: "0px 16px", borderRadius: "5px" },
    },
    {
      label: <LineButton />,
      key: "line",
      style: { padding: "0px", margin: "0px 16px", borderRadius: "5px" },
    },
    {
      label: <Link to="user">會員中心</Link>,
      key: "user",
      icon: <UserOutlined />,
      style: { position: "absolute", right: "120px" },
    },
    {
      label: <Link to="cart">購物車</Link>,
      key: "cart",
      icon: <ShoppingCartOutlined />,
      style: { position: "absolute", right: "20px" },
    },
  ];

  return (
    <Header
      style={{
        display: "flex",
        alignItems: "center",
      }}
    >
      <div className="demo-logo" />
      <Menu
        theme="dark"
        mode="horizontal"
        items={items}
        style={{
          flex: 1,
          minWidth: 0,
          alignItems: "center",
        }}
        onClick={({ key }) => console.log("hello" + key)}
      />
    </Header>
  );
};

export default Nav;

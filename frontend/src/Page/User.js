import { Link } from "react-router-dom";

import { Layout, Breadcrumb, theme, Tabs } from "antd";
import DataForm from "../Components/user/DataForm";
import History from "../Components/user/History";
const { Content } = Layout;

const User = () => {
  const onChange = (key) => {
    console.log(key);
  };
  const items = [
    {
      key: "1",
      label: "會員資料",
      children: <DataForm />,
    },
    {
      key: "2",
      label: "歷史訂單",
      children: <History />,
    },
  ];

  const {
    token: { colorBgContainer, borderRadiusLG },
  } = theme.useToken();

  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Breadcrumb
          items={[
            {
              title: <Link to="/">首頁</Link>,
            },
            {
              title: "會員中心",
            },
          ]}
          style={{ paddingBottom: "2rem" }}
        />
        <div
          style={{
            background: colorBgContainer,
            minHeight: 280,
            padding: 24,
            borderRadius: borderRadiusLG,
          }}
        >
          <Tabs defaultActiveKey="1" items={items} onChange={onChange} />
        </div>
      </Content>
    </Layout>
  );
};

export default User;

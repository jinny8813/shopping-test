import { Layout, Button, Result } from "antd";
import { Link } from "react-router-dom";
const { Content } = Layout;

const contentStyle = {
  height: "360px",
  color: "#fff",
  lineHeight: "360px",
  textAlign: "center",
  background: "#364d79",
};

const PaymentSuccess = () => {
  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Result
          status="success"
          title="付款成功！祝您購物愉快: )"
          subTitle="訂單編號: 2017182818828182881"
          extra={[
            <Button type="primary" key="console">
              <Link to="/">返回首頁</Link>
            </Button>,
            <Button key="buy">
              <Link to="/store">繼續選購</Link>
            </Button>,
          ]}
        />
      </Content>
    </Layout>
  );
};

export default PaymentSuccess;

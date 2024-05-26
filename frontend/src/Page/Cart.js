import { Layout, Breadcrumb, Row, Col, Table, Input, Button } from "antd";
const { Content } = Layout;
const { TextArea } = Input;

const Cart = () => {
  const columns = [
    {
      title: "商品名稱",
      dataIndex: "name",
      key: "name",
      render: (text) => <a>{text}</a>,
    },
    {
      title: "數量",
      dataIndex: "num",
      key: "num",
    },
    {
      title: "單價",
      dataIndex: "price",
      key: "price",
    },
    {
      title: "合計",
      dataIndex: "totalPrice",
      key: "totalPrice",
    },
    {
      title: "刪除",
      dataIndex: "delete",
      key: "delete",
    },
  ];

  const data = [
    {
      key: "1",
      name: "商品一",
      num: 32,
      price: 500,
    },
    {
      key: "2",
      name: "商品二",
      num: 42,
      price: 500,
    },
    {
      key: "3",
      name: "商品三",
      num: 32,
      price: 500,
    },
  ];

  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Breadcrumb
          items={[
            {
              title: "首頁",
            },
            {
              title: "購物車",
            },
          ]}
          style={{ paddingBottom: "2rem" }}
        />
        <section style={{ padding: "1rem" }}>
          <Row justify="center" align="middle">
            <Col span={12}>
              <h2>購物車內商品</h2>
              <Table columns={columns} dataSource={data} pagination={false} />
            </Col>
          </Row>
          <br />
          <Row justify="center" align="middle">
            <Col span={12}>
              <p>如有備註請於下方註明</p>
              <TextArea
                rows={4}
                placeholder="客製化需求、運送注意事項..."
                maxLength={6}
              />
            </Col>
          </Row>
          <br />
          <Row justify="center" align="middle">
            <Col
              span={12}
              style={{ display: "flex", justifyContent: "flex-end" }}
            >
              <Button>繼續選購</Button>
              <Button type="primary" style={{ marginLeft: "1rem" }}>
                結帳
              </Button>
            </Col>
          </Row>
        </section>
      </Content>
    </Layout>
  );
};

export default Cart;

import { Link } from "react-router-dom";
import { useCart } from "../Hooks/useCart";

import {
  Layout,
  Breadcrumb,
  Row,
  Col,
  Table,
  Space,
  Input,
  Select,
  Button,
  InputNumber,
  Form,
  Checkbox,
} from "antd";
const { Content } = Layout;
const { TextArea } = Input;

const Cart = () => {
  const { cartData, deleteItem, editItem, totalPrice } = useCart();
  const columns = [
    {
      title: "商品名稱",
      dataIndex: "p_name",
      key: "p_name",
      render: (_, record) => (
        <Link to={`/store/${record.p_id}`}>{record.p_name}</Link>
      ),
    },
    {
      title: "數量",
      dataIndex: "p_num",
      key: "p_num",
      render: (_, record) => (
        <InputNumber
          min={1}
          max={record.p_stock}
          defaultValue={record.p_num}
          onChange={(value) => {
            editItem(record.p_id, value);
          }}
        />
      ),
    },
    {
      title: "單價",
      dataIndex: "p_price",
      key: "p_price",
    },
    {
      title: "合計",
      dataIndex: "p_totalPrice",
      key: "p_totalPrice",
      render: (_, record) => <p>{record.p_num * record.p_price}</p>,
    },
    {
      title: "刪除",
      dataIndex: "p_delete",
      key: "p_delete",
      render: (_, record) => (
        <Button
          type="link"
          danger
          style={{ padding: "0px" }}
          onClick={() => {
            deleteItem(record.p_id);
          }}
        >
          刪除
        </Button>
      ),
    },
  ];

  const submitHandler = (values) => {
    const data = { ...values, cartData };
    console.log("Success:", data);
    postOrder(values);
  };

  async function postOrder(data) {
    const status = await fetch("/orders", {
      method: "POST",
      body: JSON.stringify(data),
    });
    const response = await status.json();

    console.log(response);
  }

  const options = [
    {
      value: "200",
      label: "200",
    },
    {
      value: "500",
      label: "500",
    },
  ];

  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Breadcrumb
          items={[
            {
              title: <Link to="/">首頁</Link>,
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
              {cartData.length > 0 ? (
                <Table
                  columns={columns}
                  dataSource={cartData}
                  pagination={false}
                />
              ) : (
                <p>目前無商品</p>
              )}
            </Col>
          </Row>
          <br />
          {cartData.length > 0 ? (
            <>
              <Row justify="center" align="middle">
                <Col span={12}>
                  <h2>總金額：{totalPrice} 元</h2>
                </Col>
              </Row>

              <Form onFinish={submitHandler}>
                <Row justify="center" align="middle">
                  <Col span={12}>
                    <h3>付款方式</h3>
                    <Form.Item
                      name="payment"
                      valuePropName="checked"
                      rules={[
                        {
                          required: true,
                          message: "請選擇支付方式！",
                        },
                      ]}
                    >
                      <Checkbox>
                        綠界支付(支援信用卡/ATM/超商繳費，下一頁填寫)
                      </Checkbox>
                    </Form.Item>

                    <div
                      style={{
                        display: "flex",
                        flexDirection: "column",
                        lineHeight: "24px",
                        paddingBottom: "24px",
                      }}
                    >
                      <h3 style={{ paddingTop: "12px" }}>配送資訊</h3>
                      <Form.Item
                        label="連絡電話"
                        name="phone"
                        rules={[
                          {
                            required: true,
                            message: "請填寫連絡電話！",
                          },
                        ]}
                      >
                        <Input />
                      </Form.Item>
                      <Form.Item label="地址" required={true}>
                        <Space.Compact block>
                          <Form.Item
                            name={["address", "code"]}
                            rules={[
                              {
                                required: true,
                                message: "請填寫郵遞區號！",
                              },
                            ]}
                            style={{ width: "20%" }}
                          >
                            <Select initialvalue="郵遞區號" options={options} />
                          </Form.Item>
                          <Form.Item
                            name={["address", "fullAddress"]}
                            rules={[
                              {
                                required: true,
                                message: "請填寫詳細地址！",
                              },
                            ]}
                            style={{ width: "80%" }}
                          >
                            <Input placeholder="詳細地址" required />
                          </Form.Item>
                        </Space.Compact>
                      </Form.Item>
                    </div>
                    <Form.Item
                      label="如有備註請註明"
                      style={{ display: "flex", flexDirection: "column" }}
                    >
                      <TextArea
                        rows={4}
                        placeholder="客製化需求、運送注意事項..."
                        maxLength={6}
                      />
                    </Form.Item>
                  </Col>
                </Row>
                <br />
                <Row justify="center" align="middle">
                  <Col
                    span={12}
                    style={{ display: "flex", justifyContent: "flex-end" }}
                  >
                    <Button>
                      <Link to="/store">繼續選購</Link>
                    </Button>
                    <Button
                      type="primary"
                      htmlType="submit"
                      style={{ marginLeft: "1rem" }}
                    >
                      結帳
                    </Button>
                  </Col>
                </Row>
              </Form>
            </>
          ) : (
            <Row justify="center" align="middle">
              <Col
                span={12}
                style={{ display: "flex", justifyContent: "center" }}
              >
                <Button type="primary" size="large">
                  <Link to="/store">前往選購</Link>
                </Button>
              </Col>
            </Row>
          )}
        </section>
      </Content>
    </Layout>
  );
};

export default Cart;

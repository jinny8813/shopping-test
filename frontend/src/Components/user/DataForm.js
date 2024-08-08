import { Button, Checkbox, Form, Input, Select, Space } from "antd";

const DataForm = () => {
  const options = [
    {
      value: "Taipei",
      label: "臺北市",
    },
    {
      value: "New Taipei City",
      label: "新北市",
    },
  ];

  const onFinish = (values) => {
    console.log("Success:", values);
  };
  const onFinishFailed = (errorInfo) => {
    console.log("Failed:", errorInfo);
  };

  return (
    <div style={{ paddingTop: "2rem" }}>
      <Form
        name="basic"
        labelCol={{
          span: 6,
        }}
        wrapperCol={{
          span: 18,
        }}
        style={{
          maxWidth: 600,
        }}
        initialValues={{
          remember: true,
        }}
        onFinish={onFinish}
        onFinishFailed={onFinishFailed}
        autoComplete="off"
      >
        <Form.Item label="帳號" name="username">
          <Input disabled={true} />
        </Form.Item>

        <Form.Item
          label="密碼"
          name="password"
          rules={[
            {
              required: true,
              message: "Please input your password!",
            },
          ]}
        >
          <Input.Password />
        </Form.Item>

        <Form.Item
          label="電話"
          name="phone"
          rules={[
            {
              required: true,
              message: "Please input your phone!",
            },
          ]}
        >
          <Input />
        </Form.Item>

        <Form.Item
          label="常用地址"
          name="address"
          rules={[
            {
              required: true,
              message: "Please input your address!",
            },
          ]}
        >
          <Space.Compact style={{ width: "100%" }}>
            <Select
              defaultValue="縣市"
              options={options}
              style={{ width: "30%" }}
            />
            <Input placeholder="詳細地址" />
          </Space.Compact>
        </Form.Item>

        <Form.Item
          wrapperCol={{
            offset: 12,
            span: 12,
          }}
        >
          <Button type="primary" htmlType="submit">
            更新資料
          </Button>
        </Form.Item>
      </Form>
    </div>
  );
};

export default DataForm;

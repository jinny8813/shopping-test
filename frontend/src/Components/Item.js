import { Col, Card } from "antd";
const { Meta } = Card;

const Item = ({ item }) => {
  return (
    <Col span={6} style={{ paddingBottom: "2rem" }}>
      <Card
        hoverable
        style={{
          width: "14rem",
        }}
        cover={<img alt="example" src={item.p_img} />}
      >
        <Meta
          title={item.p_name}
          description={`價格：${item.p_price}`}
          style={{ textAlign: "center" }}
        />
      </Card>
    </Col>
  );
};

export default Item;

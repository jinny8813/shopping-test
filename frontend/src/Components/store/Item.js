import { Col, Card } from "antd";
import { Link } from "react-router-dom";
const { Meta } = Card;

const Item = ({ item }) => {
  return (
    <Col span={6} style={{ paddingBottom: "2rem" }}>
      <Card
        hoverable
        style={{
          display: "flex",
          flexDirection: "column",
          alignItems: "center",
          textAlign: "center",
          width: "14rem",
        }}
        cover={<img alt="example" src={item.p_img} />}
      >
        <Meta
          title={item.p_name}
          description={`價格：${item.p_price}`}
          style={{ marginBottom: "15px" }}
        />
        <Link to={`/store/${item.p_id}`}>詳細資訊</Link>
      </Card>
    </Col>
  );
};

export default Item;

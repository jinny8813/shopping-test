import { useState, useEffect } from "react";
import { Row, Col, Menu, Input, Layout, Tag } from "antd";
import Item from "../Components/store/Item";
import Dropdown from "../Components/UI/Dropdown";
import Breadcrumb from "../Components/UI/store/Breadcrumb";
const { Content } = Layout;
const { Search } = Input;

const Store = () => {
  const [products, setProducts] = useState();

  function getItem(label, key, children, type) {
    return {
      key,
      children,
      label,
      type,
    };
  }
  const items = [
    getItem("3C週邊", "sub1", [
      getItem(
        "Item 1",
        null,
        null,
        [getItem("Option 1", "1"), getItem("Option 2", "2")],
        "group"
      ),
      getItem(
        "Item 2",
        null,
        null,
        [getItem("Option 3", "3"), getItem("Option 4", "4")],
        "group"
      ),
    ]),
    getItem("DIY零組件", "sub2", [
      getItem("Option 5", "5"),
      getItem("Option 6", "6"),
      getItem("Submenu", "sub3", null, [
        getItem("Option 7", "7"),
        getItem("Option 8", "8"),
      ]),
    ]),
    getItem("其他配件", "sub4", [
      getItem("Option 9", "9"),
      getItem("Option 10", "10"),
      getItem("Option 11", "11"),
      getItem("Option 12", "12"),
    ]),
  ];
  const onClick = (e) => {
    console.log("click", e);
  };

  const onSearch = (value, _e, info) => console.log(info?.source, value);

  async function getData() {
    const response = await fetch("/product");
    const data = await response.json();

    setProducts(data.data);
    console.log(data.data);
  }

  useEffect(() => {
    getData();
  }, []);

  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Breadcrumb title={"零組件"} />
        <Row>
          <Col span={4}>
            <Menu onClick={onClick} mode="vertical" items={items} />
          </Col>

          <Col span={20}>
            <Row align="middle">
              <Col span={8} offset={1}>
                <Dropdown />
              </Col>
              <Col span={8} offset={5}>
                <Search placeholder="搜尋商品" onSearch={onSearch} />
              </Col>
            </Row>
            <div style={{ padding: "2rem" }}>
              <Row>
                {products ? (
                  products.map((product) => (
                    <Item item={product} key={product.p_id} />
                  ))
                ) : (
                  <Col
                    span={20}
                    style={{ display: "flex", justifyContent: "center" }}
                  >
                    <img src="/assets/Loading_gray.gif"></img>
                  </Col>
                )}
              </Row>
            </div>
          </Col>
        </Row>
      </Content>
    </Layout>
  );
};

export default Store;

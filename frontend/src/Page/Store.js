import product from "./product.json";

import { useState, useEffect } from "react";
import { Row, Col, Breadcrumb, Menu, Input, Layout, Tag } from "antd";
import Item from "../Components/Item";
import Dropdown from "../Components/UI/Dropdown";
const { Content } = Layout;
const { Search } = Input;

const Store = () => {
  const [products, setProducts] = useState(product);

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
    console.log(products);
  }

  useEffect(() => {
    getData();
  }, []);

  return (
    <Layout>
      <Content style={{ padding: "2rem 8rem" }}>
        <Breadcrumb
          items={[
            {
              title: "首頁",
            },
            {
              title: <a href="">線上商店</a>,
            },
            {
              title: "零組件",
            },
          ]}
          style={{ paddingBottom: "2rem" }}
        />
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
                {products.map((product) => (
                  <Item item={product} key={product.p_id} />
                ))}
              </Row>
            </div>
          </Col>
        </Row>
      </Content>
    </Layout>
  );
};

export default Store;

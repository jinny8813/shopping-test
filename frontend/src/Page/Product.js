import React, { useState, useEffect } from "react";

import {
  Col,
  Row,
  Breadcrumb,
  Layout,
  theme,
  Image,
  InputNumber,
  Button,
  Tabs,
  message,
} from "antd";
import Carousel from "../Components/Carousel";
const { Content } = Layout;

const Product = () => {
  const [productData, setProductData] = useState({
    p_id: "2",
    p_name:
      "全新現貨 台灣出貨 Darkflash DS900 ATX 全景機殼 電競遊戲機殼 可安裝360水冷 海景機",
    p_description: "物品狀況：全新",
    p_price: "2,990",
    p_stock: "10",
    p_image: "https://gcs.rimg.com.tw/g1/f/a4/6b/22350391095403_337.png",
    p_type: "main",
  });

  const [messageApi, contextHolder] = message.useMessage();
  const success = () => {
    messageApi.open({
      type: "success",
      content: "已加入購物車",
    });
  };

  const tabOnChange = () => {};

  const {
    token: { colorBgContainer, borderRadiusLG },
  } = theme.useToken();

  async function getData() {
    const response = await fetch("/product/2");
    const data = await response.json();

    setProductData(data.data);
    console.log(productData);
  }

  useEffect(() => {
    getData();
  }, []);

  return (
    <Layout>
      {contextHolder}
      <Content
        style={{
          padding: "2rem 8rem",
        }}
      >
        <Breadcrumb
          items={[
            {
              title: "首頁",
            },
            {
              title: <a href="">線上商店</a>,
            },
            {
              title: "客製化主機",
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
          <Row justify="center" align="middle">
            <Col span={12}>
              <Carousel
                dataSource={[
                  "https://gcs.rimg.com.tw/g1/f/a4/6b/22350391095403_337.png",
                  "https://gcs.rimg.com.tw/g1/f/0c/6b/22323872328811_168.png",
                ]}
              />
            </Col>
            <Col span={10}>
              <h1>{productData.p_name}</h1>
              <ul>
                <li>{productData.p_description}</li>
                <li>物品所在地：台灣.高雄市</li>
                <li>上架時間：2023-12-16 17:29:22</li>
              </ul>
              <hr />
              <p>{`價格：$${productData.p_price}`}</p>
              <div style={{ display: "flex", alignItems: "baseline" }}>
                <p>數量：</p>
                <InputNumber
                  min={1}
                  max={10}
                  defaultValue={1}
                  onChange={tabOnChange}
                />
              </div>
              <p>庫存：{productData.p_stock}</p>
              <Button type="primary" onClick={success}>
                加入購物車
              </Button>
            </Col>

            <Col span={24} style={{ paddingTop: "3rem" }}>
              <Tabs
                defaultActiveKey="1"
                centered
                items={[
                  {
                    key: "1",
                    label: "商品描述",
                    children: (
                      <p>
                        🔥實體店面非網路不明店家，保固最安心🔥
                        <br />
                        🔥一致好評~親切~實在~服務~效率~專業~🔥
                        <br />
                        🌸下標前請先詳閱內文，多種型號，請確認後在下標🌸
                        <br />
                        🌸有任何疑問請先私訊，我們盡量第一時間為您解答🌸
                        <br />
                        🌸此商品保固：一個月🌸 🌸報價皆為未稅價🌸
                        <br />
                        ⚠️全新品賣場，出貨前皆經測試，不接受退換貨(新品故障除外)
                        <br />
                        ⚠️請第一時間確認商品正確，都過兩個月才說實在讓賣家很為難
                        <br />
                        ⚠️購買前請先確保具備自行安裝能力和基本知識
                        <br />
                        ⚠️如個人安裝問題，皆不包含在保固範圍之內
                        (如斷腳、燒毀、不會裝、明明是支援的型號卻說裝不上等)
                        <br />
                        ⚠️商品內文中，所有支援型號皆經過測試確認可安裝
                        <br />
                        ⚠️本賣場專售電腦零組件、組裝機長期經營，請安心購買
                        <br />
                        👉全新ROG幻彩顯卡支架
                        <br />
                        🌈有多種款式，請確認後再下標 🌈高低可調 🌈防止顯卡歪斜
                        🌈最高高度18CM 🌈5V3針可接主機板同步
                        <br />
                        🙏商品流動快，歡迎聊聊詢問
                        <br />
                        ❤️營業時間為星期一~星期六，星期日公休不出貨
                        <br />
                        ❤️原則上晚上9點前下單可當天就出貨，超過九點為隔天出貨
                        <br />
                        👍優質賣家，非選不可，選擇騏騏，買安心，後勤也安心。
                        <br />
                        👉商品故障更換流程： 私訊小編{">"}告知商品故障原因{">"}
                        小編提供寄送地址{">"}回給小編{">"}小編收到商品{">"}送修
                        {">"}回件{">"}寄回維修件。
                      </p>
                    ),
                  },
                  {
                    key: "2",
                    label: "送貨及付款方式",
                    children: (
                      <ul>
                        <li>預計出貨：3天內</li>
                        <li>付款方式：信用卡6期0利率</li>
                        <li>運送方式：黑貓宅急便、宅配/快遞、面交取貨</li>
                      </ul>
                    ),
                  },
                  {
                    key: "3",
                    label: "加購商品",
                    children: (
                      <Row align="middle" style={{ textAlign: "center" }}>
                        <Col span={5}>
                          <Image
                            width={200}
                            src="https://gcs.rimg.com.tw/g1/f/0c/6b/22323872328811_168.png"
                          />
                        </Col>
                        <Col span={10}>
                          <h3>
                            全新現貨 台灣出貨 冰蝶 9CM 5V3針 ARGB 下吹式塔扇
                            有光版 / 無光版 支援Intel AMD 塔式散熱器
                          </h3>
                        </Col>
                        <Col span={3}>
                          <p>加購價：$200</p>
                        </Col>
                        <Col span={3}>
                          <div
                            style={{
                              display: "flex",
                              alignItems: "baseline",
                            }}
                          >
                            <p>數量：</p>
                            <InputNumber
                              min={1}
                              max={10}
                              defaultValue={1}
                              onChange={tabOnChange}
                            />
                          </div>
                        </Col>
                        <Col span={3}>
                          <Button type="primary" onClick={success}>
                            加購
                          </Button>
                        </Col>
                      </Row>
                    ),
                  },
                ]}
              />
            </Col>
          </Row>
        </div>
      </Content>
    </Layout>
  );
};
export default Product;

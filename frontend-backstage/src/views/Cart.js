import { EditorComponent } from "components/Tool/Editor";
import React from "react";

// react-bootstrap components
import { Card, Container, Row, Col } from "react-bootstrap";
import { Tabs, InputNumber } from "antd";

function Cart() {
  const uploadImageCallBack = () => {};

  const onChange = (value) => {
    console.log("changed", value);
  };

  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">購機資訊頁面編輯器</Card.Title>
              </Card.Header>
              <Card.Body>
                <Row>
                  <Col md="6">
                    <div className="card-image">
                      <img
                        src={require("assets/img/photo-1431578500526-4d9613015464.jpeg")}
                        style={{
                          width: "100%",
                        }}
                      />
                    </div>
                  </Col>
                  <Col md="6">
                    <h3>商品名稱</h3>
                    <p>介紹</p>
                    <hr />
                    <p>$價格</p>
                    <div style={{ display: "flex", alignItems: "baseline" }}>
                      <p>數量：</p>
                      <InputNumber
                        min={1}
                        max={10}
                        defaultValue={1}
                        onChange={onChange}
                      />
                    </div>
                  </Col>
                </Row>
              </Card.Body>
              <Card.Body>
                <Tabs
                  defaultActiveKey="1"
                  centered
                  items={[
                    {
                      label: <Card.Title as="h5">商品描述</Card.Title>,
                      key: "1",
                      children: (
                        <EditorComponent
                          toolBar={{
                            image: {
                              uploadCallback: uploadImageCallBack,
                              previewImage: true,
                            },
                          }}
                        />
                      ),
                    },
                    {
                      label: <Card.Title as="h5">送貨及付款方式</Card.Title>,
                      key: "2",
                      children: (
                        <EditorComponent
                          toolBar={{
                            image: {
                              uploadCallback: uploadImageCallBack,
                              previewImage: true,
                            },
                          }}
                        />
                      ),
                    },
                    ,
                    {
                      label: <Card.Title as="h5">加購商品</Card.Title>,
                      key: "3",
                      children: (
                        <EditorComponent
                          toolBar={{
                            image: {
                              uploadCallback: uploadImageCallBack,
                              previewImage: true,
                            },
                          }}
                        />
                      ),
                    },
                  ]}
                />
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default Cart;

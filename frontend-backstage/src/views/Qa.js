import React from "react";

// react-bootstrap components
import { Card, Container, Row, Col } from "react-bootstrap";

import { EditorComponent } from "components/Tool/Editor";

function Qa() {
  const uploadImageCallBack = () => {};

  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">線上諮詢頁面編輯器</Card.Title>
              </Card.Header>
              <Card.Body>
                <EditorComponent
                  toolBar={{
                    image: {
                      uploadCallback: uploadImageCallBack,
                      previewImage: true,
                    },
                  }}
                />
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default Qa;

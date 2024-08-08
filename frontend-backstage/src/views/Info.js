import { EditorComponent } from "components/Tool/Editor";
import React from "react";

// react-bootstrap components
import { Card, Container, Row, Col } from "react-bootstrap";

function Info() {
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">訂購須知頁面編輯器</Card.Title>
              </Card.Header>
              <Card.Body>
                <EditorComponent />
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default Info;

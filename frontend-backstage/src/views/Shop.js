import React from "react";

// react-bootstrap components
import { Card, Container, Row, Col } from "react-bootstrap";

function Shop() {
  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">線上商店</Card.Title>
              </Card.Header>
              <Card.Body></Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default Shop;

import React, { useState } from "react";
import styled from "styled-components";

// react-bootstrap components
import { Card, Table, Container, Row, Col } from "react-bootstrap";
import { Pagination } from "antd";

const StyledPagination = styled(Pagination)`
  display: flex;
  justify-content: center;
`;

const UserList = () => {
  const mockUsers = [
    {
      id: 1,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 2,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 3,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 4,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 5,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 6,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 7,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 8,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 9,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    {
      id: 10,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
    ,
    {
      id: 11,
      account: "user1@gmail.com",
      name: "洪政源",
      phone: "0960986938",
      address: "新竹市北區榮濱南路25號之6",
      store: "榮濱門市",
    },
  ];

  const [minUsers, setMinUsers] = useState(0);
  const [maxUsers, setMaxUsers] = useState(10);

  const onChange = (pageNumber) => {
    if (pageNumber === 1) {
      setMinUsers(0);
      setMaxUsers(10);
    } else {
      setMinUsers(10);
      setMaxUsers(mockUsers.length);
    }
    console.log("Page: ", pageNumber);
  };

  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card className="strpied-tabled-with-hover">
              <Card.Header>
                <Card.Title as="h4">會員列表</Card.Title>
              </Card.Header>
              <Card.Body className="table-full-width table-responsive px-0">
                <Table className="table-hover table-striped">
                  <thead>
                    <tr>
                      <th className="border-0">會員ID</th>
                      <th className="border-0">會員帳號</th>
                      <th className="border-0">會員名稱</th>
                      <th className="border-0">電話</th>
                      <th className="border-0">常用地址</th>
                      <th className="border-0">常用取貨門市</th>
                    </tr>
                  </thead>
                  <tbody>
                    {mockUsers.slice(minUsers, maxUsers).map((user) => (
                      <tr key={user.id}>
                        <td>{user.id}</td>
                        <td>{user.account}</td>
                        <td>{user.name}</td>
                        <td>{user.phone}</td>
                        <td>{user.address}</td>
                        <td>{user.store}</td>
                      </tr>
                    ))}
                  </tbody>
                </Table>
                <StyledPagination
                  showQuickJumper
                  defaultCurrent={1}
                  total={mockUsers.length}
                  onChange={onChange}
                />
              </Card.Body>
            </Card>
          </Col>
          {/* <Col md="12">
            <Card className="card-plain table-plain-bg">
              <Card.Header>
                <Card.Title as="h4">Table on Plain Background</Card.Title>
                <p className="card-category">
                  Here is a subtitle for this table
                </p>
              </Card.Header>
              <Card.Body className="table-full-width table-responsive px-0">
                <Table className="table-hover">
                  <thead>
                    <tr>
                      <th className="border-0">ID</th>
                      <th className="border-0">Name</th>
                      <th className="border-0">Salary</th>
                      <th className="border-0">Country</th>
                      <th className="border-0">City</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Dakota Rice</td>
                      <td>$36,738</td>
                      <td>Niger</td>
                      <td>Oud-Turnhout</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Minerva Hooper</td>
                      <td>$23,789</td>
                      <td>Curaçao</td>
                      <td>Sinaai-Waas</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Sage Rodriguez</td>
                      <td>$56,142</td>
                      <td>Netherlands</td>
                      <td>Baileux</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Philip Chaney</td>
                      <td>$38,735</td>
                      <td>Korea, South</td>
                      <td>Overland Park</td>
                    </tr>
                    <tr>
                      <td>5</td>
                      <td>Doris Greene</td>
                      <td>$63,542</td>
                      <td>Malawi</td>
                      <td>Feldkirchen in Kärnten</td>
                    </tr>
                    <tr>
                      <td>6</td>
                      <td>Mason Porter</td>
                      <td>$78,615</td>
                      <td>Chile</td>
                      <td>Gloucester</td>
                    </tr>
                  </tbody>
                </Table>
              </Card.Body>
            </Card>
          </Col> */}
        </Row>
      </Container>
    </>
  );
};

export default UserList;

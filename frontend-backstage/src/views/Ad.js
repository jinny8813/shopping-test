import React, { useState } from "react";

// react-bootstrap components
import { Card, Container, Row, Col } from "react-bootstrap";
import { UploadOutlined, LoadingOutlined } from "@ant-design/icons";
import {
  Button as AntButton,
  message,
  Upload,
  Form as AntForm,
  Input,
} from "antd";

function Ad() {
  const [loading, setIsLoading] = useState(false);
  const [imageUrl, setImageUrl] = useState();

  const props = {
    name: "file",
    action: "/",
    headers: {
      authorization: "authorization-text",
    },
    onChange(info) {
      if (info.file.status !== "uploading") {
        console.log(info.file, info.fileList);
        setIsLoading(true);
      }
      setImageUrl(URL.createObjectURL(info.file.originFileObj));
      if (info.file.status === "done") {
        message.success(`${info.file.name} file uploaded successfully`);
      } else if (info.file.status === "error") {
        message.error(`${info.file.name} file upload failed.`);
      }
    },
  };

  const [fields1, setFields1] = useState({
    youtubeLink: "https://www.youtube.com/embed/yp3DkJlPr1Y?",
  });
  const [fields2, setFields2] = useState({
    youtubeLink: "https://www.youtube.com/embed/yp3DkJlPr1Y?",
  });
  const [fields3, setFields3] = useState({
    youtubeLink: "https://www.youtube.com/embed/yp3DkJlPr1Y?",
  });
  const [form1, form2, form3] = AntForm.useForm();

  const videoUploader1 = (values) => {
    console.log("Success", values);
    form1.resetFields();
    let splitProcess = values.youtubeLink1.split("=");
    let id = splitProcess[1];
    setFields1({
      youtubeLink: `https://www.youtube.com/embed/${id}?`,
    });
  };
  const videoUploader2 = (values) => {
    console.log("Success", values);
    form2.resetFields();
    let splitProcess = values.youtubeLink2.split("=");
    let id = splitProcess[1];
    setFields2({
      youtubeLink: `https://www.youtube.com/embed/${id}?`,
    });
  };
  const videoUploader3 = (values) => {
    console.log("Success", values);
    form3.resetFields();
    let splitProcess = values.youtubeLink3.split("=");
    let id = splitProcess[1];
    setFields3({
      youtubeLink: `https://www.youtube.com/embed/${id}?`,
    });
  };

  return (
    <>
      <Container fluid>
        <Row>
          <Col md="12">
            <Card>
              <Card.Header>
                <Card.Title as="h4">變更廣告橫幅</Card.Title>
              </Card.Header>
            </Card>
          </Col>
          <Col md="12">
            <Card>
              <Card.Body>
                <h5>版位1</h5>
                <Row>
                  <Col>
                    <Upload name="ad1" {...props}>
                      <AntButton icon={<UploadOutlined />}>
                        上傳影片/圖片
                      </AntButton>
                    </Upload>
                    <div className="card-image">
                      <img
                        src={
                          imageUrl
                            ? imageUrl
                            : require("assets/img/sidebar-3.jpg")
                        }
                        style={{
                          width: "100%",
                        }}
                      />
                    </div>
                  </Col>
                  <Col>
                    <AntForm
                      form={form1}
                      onFinish={videoUploader1}
                      layout="inline"
                    >
                      <AntForm.Item label="或嵌入影片：" name="youtubeLink1">
                        <Input placeholder="請輸入YouTube影片網址" />
                      </AntForm.Item>
                      <AntForm.Item>
                        <AntButton htmlType="submit">嵌入</AntButton>
                      </AntForm.Item>
                    </AntForm>
                    <iframe
                      width="560"
                      height="315"
                      src={fields1.youtubeLink}
                      title="YouTube video player"
                      frameBorder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowFullScreen
                    ></iframe>
                  </Col>
                </Row>
              </Card.Body>
            </Card>
          </Col>
          <Col md="12">
            <Card>
              <Card.Body>
                <h5>版位2</h5>
                <Row>
                  <Col>
                    <Upload>
                      <AntButton icon={<UploadOutlined />}>
                        上傳影片/圖片
                      </AntButton>
                    </Upload>
                    <div className="card-image">
                      <img src={require("assets/img/sidebar-3.jpg")}></img>
                    </div>
                  </Col>
                  <Col>
                    <AntForm
                      form={form2}
                      onFinish={videoUploader2}
                      layout="inline"
                    >
                      <AntForm.Item label="或嵌入影片：" name="youtubeLink2">
                        <Input placeholder="請輸入YouTube影片網址" />
                      </AntForm.Item>
                      <AntForm.Item>
                        <AntButton htmlType="submit">嵌入</AntButton>
                      </AntForm.Item>
                    </AntForm>
                    <iframe
                      width="560"
                      height="315"
                      src={fields2.youtubeLink}
                      title="YouTube video player"
                      frameBorder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowFullScreen
                    ></iframe>
                  </Col>
                </Row>
              </Card.Body>
            </Card>
          </Col>
          <Col md="12">
            <Card>
              <Card.Body>
                <h5>版位3</h5>
                <Row>
                  <Col>
                    <Upload>
                      <AntButton icon={<UploadOutlined />}>
                        上傳影片/圖片
                      </AntButton>
                    </Upload>
                    <div className="card-image">
                      <img src={require("assets/img/sidebar-3.jpg")}></img>
                    </div>
                  </Col>
                  <Col>
                    <AntForm
                      form={form3}
                      onFinish={videoUploader3}
                      layout="inline"
                    >
                      <AntForm.Item label="或嵌入影片：" name="youtubeLink3">
                        <Input placeholder="請輸入YouTube影片網址" />
                      </AntForm.Item>
                      <AntForm.Item>
                        <AntButton htmlType="submit">嵌入</AntButton>
                      </AntForm.Item>
                    </AntForm>
                    <iframe
                      width="560"
                      height="315"
                      src={fields3.youtubeLink}
                      title="YouTube video player"
                      frameBorder="0"
                      allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                      allowFullScreen
                    ></iframe>
                  </Col>
                </Row>
              </Card.Body>
            </Card>
          </Col>
        </Row>
      </Container>
    </>
  );
}

export default Ad;
